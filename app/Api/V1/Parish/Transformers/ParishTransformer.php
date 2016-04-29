<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:27 PM
 */

namespace App\Api\V1\Parish\Transformers;
use App\Api\V1\Transformers\Transformer;


class ParishTransformer extends Transformer {

    public function transform($parish)
    {
        return [

            'id'           => $parish['id'],
            'parish_name'  => $parish['parish_name'],
        ];
    }

} 