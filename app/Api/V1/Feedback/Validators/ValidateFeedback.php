<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/1/16
 * Time: 9:53 AM
 */

namespace App\Api\V1\Feedback\Validators;

use App\Api\V1\Validator\ApiValidator;
use Validator;
use Dingo\Api\Exception\ValidationHttpException;


class ValidateFeedback extends ApiValidator {

    /**
     * Validate the incoming feedback data
     * @param $feedbackData
     * @return mixed
     * @throws \Dingo\Api\Exception\ValidationHttpException
     */
    public function validateFeedback($feedbackData){

        $validator = Validator::make($feedbackData, [
                'mood' => 'required|numeric',
                'comment' => 'required'
        ]);

        $this->validate($validator);
    }
} 