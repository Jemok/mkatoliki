<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:28 PM
 */

namespace App\Api\V1\Transformers;


class HappeningTransformer extends Transformer {

    public function transform($happening)
    {
        return [
            'event_title' => $happening['event_title'],
            'event_body'  => $happening['event_body'],
            'event_excerpt' => $happening['event_excerpt'],
            'event_date'   => $happening['event_date']
        ];
    }

} 