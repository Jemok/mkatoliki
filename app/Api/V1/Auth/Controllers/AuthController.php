<?php
/**
 * The authentication controller that handles
 * the login. registration and logout logic
 */
namespace App\Api\V1\Auth\Controllers;

use App\Api\V1\Account\Models\Role;
use App\Api\V1\Auth\Services\SetUserRole;
use App\Api\V1\Auth\Traits\Login;
use App\Api\V1\Auth\Transformers\UserTransformer;
use App\Api\V1\Auth\Validators\ValidateLogin;
use App\Api\V1\Auth\Validators\ValidateSignup;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
use App\Api\V1\Subscription\Repositories\SubscriptionRepository;
use Carbon\Carbon;
use JWTAuth;
use Validator;
use Config;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Dingo\Api\Exception\ValidationHttpException;
use App\Api\V1\Account\Repositories\UserRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Api\V1\Mailers\AppMailer;
use App\Api\V1\Account\Models\User;

class AuthController extends Controller
{
    /**
     * Login Trait
     */
    use Login;

    /**
     * Validate Login Trait
     */
    use ValidateLogin;

    /**
     * Validate SignUp Trait
     */
    use ValidateSignup;

    /**
     * Holds the login mode
     * @var
     */
    protected $login_type;

    /**
     * Handles Login in a user into the app from the web
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */

    public function loginDefault(Request $request)
    {
        //Only Email and Password are required for login(for web app)
        $credentials = $request->only(['email', 'password']);

        $this->login_type = 'web';

        //Validate Incoming input from request
        $this->validateLogin($credentials, $this->login_type);

        //Login the user
        return $this->login($credentials, $this->login_type, new UserTransformer());
    }

    /**
     * Handles registration of a new user into the API
     * @param Request $request
     * @param UserRepository $userRepository
     * @param SetUserRole $setUserRole
     * @param SubscriptionRepository $subscriptionRepository
     * @return \Dingo\Api\Http\Response|\Illuminate\Http\JsonResponse|void
     */

    public function signup(Request $request, UserRepository $userRepository, SetUserRole $setUserRole, SubscriptionRepository $subscriptionRepository)
    {
        // Get the sign up fields from the Sign up fields boilerplate in
        // app/config/boilerplate.php
        $signupFields = Config::get('boilerplate.signup_fields');

        //A token is released by the api depending on either the value is true or false
        $hasToReleaseToken = Config::get('boilerplate.signup_token_release');

        //Set the fields to be used for registration
        $userData = $request->only($signupFields);

        //Validate request user data against the signup validation rules
        $this->validateSignup($userData, Config::get('boilerplate.signup_fields_rules'));

        //Save the user to the database
        $user = $userRepository->store($userData);

        //If there was an error, return response error message
        if(!$user->id) {
            return $this->response->error('could_not_create_user', 500);
        }

        // Set the role of a user
        $setUserRole->setRole($user, $request);

        // Set a default subscription for the user
        $subscriptionRepository->defaultSubscription($user);

        //Login the user
        if($hasToReleaseToken) {
            return $this->loginDefault($request);
        }

        $mailer = new AppMailer();


        if($mailer->sendConfirmEmailLink($user)){
            //If successfully created the user, return response success
            return response()->json(['message'=>'User was successfully created and a confirmation email has been sent to them'], 201);
        }

        return response()->json(['message' => 'There was an error creating the user'], 500);
    }



    /**
     * Retrieves the authenticated user
     * @param UserTransformer $userTransformer
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getAuthenticatedUser(UserTransformer $userTransformer)
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        // return response()->json(compact('user'));
        return $userTransformer->transform($user);
    }

    /**
     * Handles the recovery of a user account using their email
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */
    public function recovery(Request $request)
    {
        //Start the validation process
        $validator = Validator::make($request->only('email'), [
            'email' => 'required'
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        //Send account recovery link
        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject(Config::get('boilerplate.recovery_email_subject'));
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->response->noContent();
            case Password::INVALID_USER:
                return $this->response->errorNotFound();
        }
    }

    /**
     * Display the password reset view for the given token.
     * @param null $token
     * @return $this
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        return view('auth.reset')->with('token', $token);
    }

    /**
     * Handles the resetting of a users authentication credentials
     * @param Request $request
     * @return \Dingo\Api\Http\Response|\Illuminate\Http\JsonResponse|void
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */
    public function reset(Request $request)
    {
        //Handles the resseting of the account
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        //Start validation
        $validator = Validator::make($credentials, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //Reset the account
        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                if(Config::get('boilerplate.reset_token_release')) {
                    return $this->loginDefault($request);
                }
                //return $this->response->noContent();
                Session::flash('flash_message', 'Your password was rest successfully, you can now login to the mobile app using the new password');
                return redirect()->back();

            default:
                //return $this->response->error('could_not_reset_password', 500);
                Session::flash('flash_message_error', 'We could not reset your password, try resending a reset link again from the mobile app');
                return redirect()->back();
        }
    }

    public function confirmEmail($token)
    {
        //User::whereToken($token)->firstOrFail()->confirmEmail();
        if(User::whereToken($token)->exists()){

            User::whereToken($token)->firstOrFail()->confirmEmail();

            Session::flash('flash_message', 'Your email was confirmed successfully, you can now login in the mobile app');

            return view('verification.success');

        }

        Session::flash('flash_message', 'Your email is already confirmed, try login in the mobile app');

        return view('verification.fail');

    }
}