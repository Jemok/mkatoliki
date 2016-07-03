<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 6/25/16
 * Time: 7:54 AM
 */

namespace App\Api\V1\Auth\Transformers;


use App\Api\V1\Transformers\Transformer;

class UserTransformer extends Transformer {


    public function transform($user){

        if(isset($user['auth_token']) && !empty($user['auth_token'])){

            return [
                'token' => $user['auth_token'],
                'message' => 'success',
                'user' => $this->getUserDetailsArray($user)

            ];
        }

        return [ 'user' => $this->getUserDetailsArray($user)];
    }

    private function getUserDetailsArray($user){

        return [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'verified' =>  (int) $user['verified'],
                'phone_number' => $user['phone_number'],
                'parish_id'    => (int) $user['parish_id'],
                'station_id'   => (int) $user['station_id'],
                'user_role'    => (int) $user['role_id'],
                'created_at'   => $user['created_at'],
                'updated_at'   => $user['updated_at']
        ];
    }
} 