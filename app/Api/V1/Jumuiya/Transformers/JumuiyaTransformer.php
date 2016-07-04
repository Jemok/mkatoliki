<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:27 PM
 */

namespace App\Api\V1\Jumuiya\Transformers;

use App\Api\V1\Transformers\Transformer;


class JumuiyaTransformer extends Transformer {

    public function transform($jumuiya)
    {
        return [
            'id'                 => $jumuiya['id'],
            'jumuiya_location'   => $jumuiya['location'],
            'jumuiya_event_date' => $jumuiya['happening_on'],
            'raw_jumuiya_id'     => $jumuiya['raw_jumuiya_id'],
            'more_details'       => $jumuiya['more_details'],
            'day_event_name' => $jumuiya['day_event_name'],
            'mass'               => (int) $jumuiya['mass']
        ];
    }
} 