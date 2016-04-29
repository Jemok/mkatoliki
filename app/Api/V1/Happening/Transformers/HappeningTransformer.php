<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:28 PM
 */

namespace App\Api\V1\Happening\Transformers;
use App\Api\V1\Transformers\Transformer;

class HappeningTransformer extends Transformer {

    public function transform($happening)
    {
        return [
            'id'                    => $happening['id'],
            'happening_event_title' => $happening['event_title'],
            'happening_event_body'  => $happening['event_body'],
            'happening_event_excerpt' => $happening['event_excerpt'],
            'happening_event_date'   => $happening['event_date']
        ];
    }
} 