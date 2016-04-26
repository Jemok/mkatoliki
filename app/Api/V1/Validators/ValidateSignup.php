<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/24/16
 * Time: 3:54 PM
 */

namespace App\Api\V1\Validators;

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

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        return $validator;
    }

} 