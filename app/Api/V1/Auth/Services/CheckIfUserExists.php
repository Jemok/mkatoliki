<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/6/16
 * Time: 8:37 PM
 */

namespace App\Api\V1\Auth\Services;


use App\Api\V1\Account\Models\User;

class CheckIfUserExists {

    public function checkEmail($request){

        if(User::where('email', $request->get('email'))->exists()){

            return response()->json(['message' => 'Email is used', 'value' => 1], 422);

        }else{

            return response()->json(['message' => 'Email is not used', 'value' => 0], 200);

        }

    }

    public function checkPhone($request){

        if(User::where('phone_number', $request->get('phone_number'))->exists()){

            return response()->json(['message' => 'Number is already used', 'value' => 1], 422);

        }else{

            return response()->json(['message' => 'Number is not used', 'value' => 0], 200);

        }

    }
} 