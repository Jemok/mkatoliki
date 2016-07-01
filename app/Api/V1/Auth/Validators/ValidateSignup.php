<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/24/16
 * Time: 3:54 PM
 */

namespace App\Api\V1\Auth\Validators;

use App\Api\V1\Validator\ApiValidator;
use Validator;
use Dingo\Api\Exception\ValidationHttpException;

trait ValidateSignup {

    /**
     * Validate a new signup request
     * @param $userData
     * @param $signup_fields
     * @return mixed
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */
    public function validateSignup($userData, $signup_fields){

        //Start the validation process
        $validator = Validator::make($userData, $signup_fields);

        $apiValidator = new ApiValidator;

        $apiValidator->validate($validator);
    }

} 