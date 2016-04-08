<?php

namespace App\Api\V1\Controllers;

use App\Reflection;
use App\User_parishes;
use App\User_stations;
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
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthControllerPhone extends Controller
{
    use Helpers;

    public function login(Request $request)
    {
        $credentials = $request->only(['phone_number', 'password']);

        $validator = Validator::make($credentials, [
            'phone_number' => 'required',
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

        if(isset($token)){

            $user = \Auth::user();

            $parish_id = \Auth::user()->user_parishes()->first()->parish_id;

            $station_id = \Auth::user()->user_stations()->first()->station_id;

            $user->parish_id = $parish_id;
            $user->station_id =$station_id;

        }


        return response()->json(compact('token', 'user'));
    }

    public function getAuthenticatedUser()
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
        return response()->json(compact('user'));
    }

    /**
     * The logout method
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request){

        $token = $request->input('token');

        JWTAuth::invalidate($token);

        return response()->json(compact('token'));

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