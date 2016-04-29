<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:27 PM
 */

namespace App\Api\V1\Reflection\Transformers;
use App\Api\V1\Transformers\Transformer;

class ReflectionTransformer extends Transformer {

    public function transform($reflection)
    {
        return [
            'id' =>  $reflection['id'],
            'reflection_body' => $reflection['reflection_body'],
            'reflection_date'  => $reflection['reflection_date'],
            'reading_id'       => $reflection['reading_id']
        ];
    }
} 