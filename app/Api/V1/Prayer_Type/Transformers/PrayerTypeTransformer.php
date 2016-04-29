<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:26 PM
 */

namespace App\Api\V1\Prayer_Type\Transformers;
use App\Api\V1\Transformers\Transformer;

class PrayerTypeTransformer extends Transformer {

    public function transform($prayer_type)
    {
        return [

            'id'          => $prayer_type['id'],
            'prayer_type_name' => $prayer_type['prayer_type_name'],
            'prayer_type_description' => $prayer_type['prayer_type_description']
        ];
    }

}