<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/24/16
 * Time: 3:11 PM
 */

namespace App\Api\V1\Auth\Validators;
use Validator;
use Dingo\Api\Exception\ValidationHttpException;
use App\Api\V1\Validator\ApiValidator;

trait ValidateLogin {

    /**
     * Default login key is email, its determined by the
     * the login type
     * @var string
     */
    protected $key = 'email';

    /**
     * Default validation rules for the email field
     * @var string
     */
    protected $key_validation = 'required|email|max:255';

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
            $this->key_validation = 'required|max:10|min:10';
        }
        //Validate the input incoming into the API from a client
        $validator = Validator::make($credentials, [
            $this->key => $this->key_validation,
            'password' => 'required',
        ]);

        $apiValidator = new ApiValidator;

        $apiValidator->validate($validator);
    }
} 