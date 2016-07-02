<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/2/16
 * Time: 7:30 AM
 */

namespace App\Api\V1\Auth\Services;
use App\Api\V1\Account\Models\Role;


class SetUserRole {

    public function setRole($user,$request){

        if($request->path() == 'api/auth/signup-mkatoliki-admin'){
            return $this->execute($user, 0);
        }
        if($request->path() == 'api/auth/signup-parish-admin'){
            return $this->execute($user, 1);
        }
        if($request->path() == 'api/auth/signup-outstation-admin'){
            return $this->execute($user, 2);
        }
        if($request->path() == 'api/auth/signup-priest'){
            return $this->execute($user, 3);
        }
        if($request->path() == 'api/auth/signup'){
           return $this->execute($user, 4);
        }
    }

    private function execute($user, $role_power){
        $role = Role::where('role_power', $role_power)->first();
        return $user->user_role()->create([
            'role_id' => $role->id
        ]);
    }
} 