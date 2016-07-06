<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/6/16
 * Time: 6:36 PM
 */

namespace App\Api\V1\Search;


use App\Api\V1\Validator\ApiValidator;
use Validator;

class ValidateSearch extends ApiValidator {

    public function validateSearch($searchData){

        $validator = Validator::make($searchData, [

            'query' => 'required'

        ]);

        return $this->validate($validator);

    }

} 