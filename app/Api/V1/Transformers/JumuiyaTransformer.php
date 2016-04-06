<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:27 PM
 */

namespace App\Api\V1\Transformers;


class JumuiyaTransformer extends Transformer {

    public function transform($jumuiya)
    {
        return [

            'jumuiya_location'  => $jumuiya['location'],
            'jumuiya_event_date' => $jumuiya['happening_on'],
            'raw_jumuiya_id'          => $jumuiya['raw_jumuiya_id']
        ];
    }

} 