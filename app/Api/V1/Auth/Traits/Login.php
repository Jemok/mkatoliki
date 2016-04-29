<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/24/16
 * Time: 12:33 PM
 */

namespace App\Api\V1\Auth\Traits;

use JWTAuth;
use Validator;
use Config;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Exceptions\JWTException;


trait Login {

    /**
     * Login in users to the application
     * @param $credentials
     * @param $login_type
     * @return \Illuminate\Http\JsonResponse
     */

    public function login($credentials, $login_type)
    {

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

            if($login_type == 'phone'){

                $parish_id = \Auth::user()->user_parishes()->first()->parish_id;

                $station_id = \Auth::user()->user_stations()->first()->station_id;

                $user->parish_id = $parish_id;
                $user->station_id =$station_id;
            }

        }

        //Return the jwt token and the authenticated user details
        return response()->json(compact('token', 'user'));
    }

} 