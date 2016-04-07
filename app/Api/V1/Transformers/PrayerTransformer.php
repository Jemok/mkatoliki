<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/7/16
 * Time: 12:07 PM
 */

namespace App\Api\V1\Transformers;


class PrayerTransformer extends Transformer {

    public function transform($prayer)
    {
        return [

            'id'          => $prayer['id'],
            'prayer_title' => $prayer['prayer_title'],
            'prayer_body' => $prayer['prayer_body'],
            'prayer_type_id' => $prayer['prayer_type_id']

        ];
    }

}