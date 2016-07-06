<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/6/16
 * Time: 8:54 PM
 */

namespace App\Api\V1\Auth\Validators;


use App\Api\V1\Validator\ApiValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Validator;

class ValidateUserChecks extends ApiValidator {

    public function validateUserCheckEmail($checkData){

        $validator = Validator::make($checkData, [

            'email' => 'required|email'

        ]);

        return $this->validate($validator);

    }

    public function validateUserCheckPhoneNumber($checkData){

        $validator = Validator::make($checkData, [

            'phone_number' => 'required|max:10|min:10'

        ]);

        return $this->validate($validator);

    }

} 