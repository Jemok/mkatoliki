<?php

// This is repeated code,, move it away from here completely

namespace App\Api\V1\Auth\Controllers;

use App\Api\V1\Account\Models\User_parishes;
use App\Api\V1\Account\Models\User_stations;
use App\Api\V1\Auth\Transformers\LogoutTransformer;
use App\Api\V1\Auth\Transformers\UserTransformer;
use JWTAuth;
use Config;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Api\V1\Auth\Traits\Login;
use App\Api\V1\Auth\Validators\ValidateLogin;
use App\Http\Controllers\Controller;

class AuthControllerPhone extends Controller
{
    use Helpers;
    use Login;
    use ValidateLogin;

    /**
     * Holds the login mode
     * @var
     */
    protected $login_type;

    /**
     * Handles login a user using the phone model
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginPhone(Request $request)
    {
        $this->login_type = 'phone';

        //Only phone_number and password are required for login(for mobile app)
        $credentials = $request->only(['phone_number', 'password']);

        //Validate Incoming input from request
        $this->validateLogin($credentials, $this->login_type);

        //Login the user
        return $this->login($credentials, $this->login_type, new UserTransformer());
    }

    /**
     * Logout users out of the application
     * @param Request $request
     * @param LogoutTransformer $logoutTransformer
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request, LogoutTransformer $logoutTransformer){

        $token = $request->input('token');

        try {

            if(JWTAuth::invalidate($token))
            {
                return $logoutTransformer->transform($token);
            }

            return response()->json(['logout_failed', 500]);

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     */
    public function setParishAndStation(Request $request){

        $user_parish = new User_parishes;
        $user_station = new User_stations;

        $user_parish->parish_id = $request->get('parish_id');

        $user_station->station_id = $request->get('station_id');


        if($this->currentUser()->user_parishes()->save($user_parish) && $this->currentUser()->user_stations()->save($user_station))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_user_parish_station', 500);
    }

    /**
     * Returns the currently logged in user
     * @return mixed
     */
    public function currentUser(){

        return JWTAuth::parseToken()->authenticate();
    }

}