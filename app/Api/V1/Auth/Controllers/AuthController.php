<?php
/**
 * The authentication controller that handles
 * the login. registration and logout logic
 */
namespace App\Api\V1\Auth\Controllers;

use App\Api\V1\Account\Models\Role;
use App\Api\V1\Auth\Traits\Login;
use App\Api\V1\Auth\Transformers\UserTransformer;
use App\Api\V1\Auth\Validators\ValidateLogin;
use App\Api\V1\Auth\Validators\ValidateSignup;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
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
     * @return \Dingo\Api\Http\Response|\Illuminate\Http\JsonResponse|void
     */

    public function signup(Request $request, UserRepository $userRepository)
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

        // Set a default subscription for the user
        $subscription = $user->subscriptions()->create([
            'subscription_category_id' => SubscriptionCategory::where('subscription_category', 2)->first()->id,
            'subscription_status_id' => SubscriptionStatus::where('status_code', 1)->first()->id
        ]);

        if($request->path() == 'api/auth/signup-mkatoliki-admin'){

            $role = Role::where('role_power', 0)->first();

            $user->user_role()->create([

                'role_id' => $role->id
            ]);
        }

        if($request->path() == 'api/auth/signup-parish-admin'){

            $role = Role::where('role_power', 1)->first();

            $user->user_role()->create([

                'role_id' => $role->id
            ]);
        }

        if($request->path() == 'api/auth/signup-outstation-admin'){

            $role = Role::where('role_power', 2)->first();

            $user->user_role()->create([

                'role_id' => $role->id
            ]);
        }

        if($request->path() == 'api/auth/signup-priest'){

            $role = Role::where('role_power', 1)->first();

            $user->user_role()->create([

                'role_id' => $role->id
            ]);
        }

        if($request->path() == 'api/auth/signup'){

            $role = Role::where('role_power', 4)->first();

            $user->user_role()->create([

                'role_id' => $role->id
            ]);
        }

        $subscription->subscription_details()->create([
            'start_date' => Carbon::now(),
            'end_date'   => Carbon::now()->addHours(SubscriptionCategory::where('subscription_category', 1)->first()->days)
        ]);
        //If there was an error, return response error message
        if(!$user->id) {
            return $this->response->error('could_not_create_user', 500);
        }
        //Login the user
        if($hasToReleaseToken) {

            return $this->loginDefault($request);
        }
        //If successfully created the user, return response success
        return $this->response->created();

        }

    /**
     * Retrieves the authenticated user
     * @return \Illuminate\Http\JsonResponse
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
            throw new ValidationHttpException($validator->errors()->all());
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
                return $this->response->noContent();

            default:
                return $this->response->error('could_not_reset_password', 500);
        }
    }
}