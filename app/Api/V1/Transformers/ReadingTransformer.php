<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:26 PM
 */

namespace App\Api\V1\Transformers;


class ReadingTransformer extends Transformer {

    public function transform($reading)
    {
        return [

            'first_reading' => $reading['first_reading'],
            'second_reading' => $reading['second_reading'],
            'responsorial_psalm' => $reading['responsorial'],
            'gospel'      => $reading['gospel']
        ];
    }

} 