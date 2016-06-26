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
use App\Api\V1\Auth\Transformers\UserTransformer;

trait Login {

    /**
     * @param $credentials
     * @param $login_type
     * @param UserTransformer $userTransformer
     * @return array
     */
    public function login($credentials, $login_type, UserTransformer $userTransformer)
    {
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }

        //If API successfully authenticated the user, get the authenticated user
        if(isset($token) && !empty($token)){

            if($login_type == 'phone'){

               $user = $this->getUserDetails($token, 'phone');

               return $userTransformer->transform($user);
            }

            $user = $this->getUserDetails($token, 'web');

            return $userTransformer->transform($user);
        }

        return $this->response->errorUnauthorized();
    }

    /**
     * Get the details of the user currently logged in
     * @param $token
     * @param $login_type
     * @return mixed
     */
    private function getUserDetails($token, $login_type){

        $user = \Auth::user();

        if($login_type == 'phone'){

            $parish_id = \Auth::user()->user_parishes()->first()->parish_id;

            $station_id = \Auth::user()->user_stations()->first()->station_id;

            $user->token = $token;
            $user->parish_id = $parish_id;
            $user->station_id =$station_id;

            return $user;
        }

        $user->token = $token;

        return $user;
    }
} 