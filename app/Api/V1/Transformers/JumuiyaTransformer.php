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
            //'jumuiya_name' => $jumuiya['jumuiya_name'],
            'jumuiya_location'  => $jumuiya['location'],
            'jumuiya_event_date' => $jumuiya['happening_on'],
            //'jumuiya_mass'          => (boolean) $jumuiya['mass']
        ];
    }

} 