<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/1/16
 * Time: 10:59 AM
 */

namespace App\Api\V1\Validator;

use Dingo\Api\Exception\ValidationHttpException;


class ApiValidator {

    /**
     * Handle Validation
     * @param $validator
     * @return mixed
     * @throws ValidationHttpException
     */
    public function validate($validator){
        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        return $validator;
    }

} 