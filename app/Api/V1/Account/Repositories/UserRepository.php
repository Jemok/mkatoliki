<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/24/16
 * Time: 4:03 PM
 */

namespace App\Api\V1\Account\Repositories;
use App\Api\V1\Account\Models\User;


class UserRepository {

    /**
     * Persist new app user to the database
     * @param $userData
     * @return static
     */
    public function store($userData){

        return $user = User::create($userData);
    }
} 