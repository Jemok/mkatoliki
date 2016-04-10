<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Validator;
use Config;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;

class AuthController extends Controller
{
    /**
     * The dingo API package routing helper
     */
    use Helpers;

    /**
     * Handles Login in a user into the API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */

    public function login(Request $request)
    {
        //Only Email and Password are required for login
        $credentials = $request->only(['email', 'password']);

        //Validate the input incoming into the API from a client
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }

        //If API successfully authenticated the user, get the authenticated user
        if(isset($token)){

            $user = \Auth::user();
        }

        //Return the jwt token and the authenticated user details
        return response()->json(compact('token', 'user'));
    }

    /**
     * Handles registration of a new user into the API
     * @param Request $request
     * @return \Dingo\Api\Http\Response|\Illuminate\Http\JsonResponse|void
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */
    public function signup(Request $request)
    {
        // Get the sign up fields from the Sign up fields boilerplate
        $signupFields = Config::get('boilerplate.signup_fields');
        $hasToReleaseToken = Config::get('boilerplate.signup_token_release');

        //Set the fields to be used for registration
        $userData = $request->only($signupFields);

        //Start the validation process
        $validator = Validator::make($userData, Config::get('boilerplate.signup_fields_rules'));

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        //Persist the new user into the database users table
        User::unguard();
        $user = User::create($userData);
        User::reguard();

        //If there was an error, return response error message
        if(!$user->id) {
            return $this->response->error('could_not_create_user', 500);
        }

        if($hasToReleaseToken) {
            return $this->login($request);
        }

        //If successfully created the usee, return response success
        return $this->response->created();
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
                    return $this->login($request);
                }
                return $this->response->noContent();

            default:
                return $this->response->error('could_not_reset_password', 500);
        }
    }
}