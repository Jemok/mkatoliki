<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/24/16
 * Time: 3:11 PM
 */

namespace App\Api\V1\Validators;
use Validator;
use Dingo\Api\Exception\ValidationHttpException;

trait ValidateLogin {

    /**
     * Default login key is email, its determined by the
     * the login type
     * @var string
     */
    protected $key = 'email';

    /**
     * Validate an incoming login request
     * @param $credentials
     * @param $login_type
     * @return mixed
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */
    public function validateLogin($credentials, $login_type){

        if($login_type == 'phone'){
            $this->key = 'phone_number';
        }

        //Validate the input incoming into the API from a client
        $validator = Validator::make($credentials, [
            $this->key => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        return $validator;
    }
} 