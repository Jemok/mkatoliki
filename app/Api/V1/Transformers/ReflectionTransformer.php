<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:27 PM
 */

namespace App\Api\V1\Transformers;


class ReflectionTransformer extends Transformer {

    public function transform($reflection)
    {
        return [
            'id' =>  $reflection['id'],
            'reflection_body' => $reflection['reflection_body'],
            //'reflection_date'  => $reflection['reflection_date'],
        ];
    }

} 