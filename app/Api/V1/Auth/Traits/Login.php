<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/24/16
 * Time: 12:33 PM
 */

namespace App\Api\V1\Auth\Traits;

use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Validator;
use Config;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Api\V1\Auth\Transformers\UserTransformer;

trait Login {

    protected $parish_id = 0;

    protected $station_id = 0;

    protected $role_id = 4;
    /**
     * @param $credentials
     * @param $login_type
     * @param UserTransformer $userTransformer
     * @return array
     */
    public function login($credentials, $login_type, UserTransformer $userTransformer)
    {
        try {
            if (! $auth_token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }

        //If API successfully authenticated the user, get the authenticated user
        if(isset($auth_token) && !empty($auth_token)){

            if($login_type == 'phone'){

               $user = $this->getUserDetails($auth_token, 'phone');

               return $userTransformer->transform($user);
            }

            $user = $this->getUserDetails($auth_token, 'web');

            return $userTransformer->transform($user);
        }

        return $this->response->errorUnauthorized();
    }

    /**
     * Get the needed authorization credentials from the request.
     * @param Request $request
     * @param $login_type
     * @return array
     */
    protected function getCredentials(Request $request, $login_type)
    {
        if($login_type == 'phone'){
            return [
                'phone_number' =>  $request->phone_number,
                'password' => $request->password,
                'verified' =>  1
            ];
        }

        if($login_type == 'web'){
            return [
                'email' =>  $request->email,
                'password' => $request->password,
                'verified' =>  1
            ];
        }
        //return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Get the details of the user currently logged in
     * @param $token
     * @param $login_type
     * @return mixed
     */
    private function getUserDetails($auth_token, $login_type){
        $user = \Auth::user();

        if(\Auth::user()->user_role()->exists()){
            $this->role_id = \Auth::user()->user_role()->first()->role_id;
        }

        if($login_type == 'phone'){

            if(\Auth::user()->user_parishes()->exists()){

                $this->parish_id = \Auth::user()->user_parishes()->first()->parish_id;
            }

            if(\Auth::user()->user_stations()->exists()){

                $this->station_id = \Auth::user()->user_stations()->first()->station_id;
            }

            $user->auth_token = $auth_token;
            $user->parish_id = $this->parish_id;
            $user->station_id =$this->station_id;
            $user->role_id = Auth::user()->user_role()->first()->role_id;

            return $user;
        }

        $user->role_id = Auth::user()->user_role()->first()->role_id;
        $user->token = $auth_token;
        $user->parish_id = $this->parish_id;
        $user->station_id =$this->station_id;

        return $user;
    }
} 