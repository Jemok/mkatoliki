<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 6/25/16
 * Time: 10:08 AM
 */

namespace App\Api\V1\Auth\Transformers;


use App\Api\V1\Transformers\Transformer;

class LogoutTransformer extends Transformer {

    public function transform($token){
        return [
            'message' => 'logged out successfully',
            'status_code' => 200
        ];
    }
} 