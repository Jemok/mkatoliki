<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:26 PM
 */

namespace App\Api\V1\Transformers;


class PrayerTransformer extends Transformer {

    public function transform($prayer)
    {
        return [

            //'prayer_name' => $prayer['title'],
            'prayer_body' => $prayer['body'],
            //'prayer_type' => $prayer['prayer_type']

        ];
    }

} 