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

            'id'           => $reading['id'],
            'readings_date' => $reading['reading_date'],
            'first_reading_title' => $reading['first_reading_title'],
            'first_reading_verse' => $reading['first_reading_book'],
            'first_reading_body' => $reading['first_reading_body'],


            'second_reading_title' => $reading['second_reading_title'],
            'second_reading_verse' => $reading['second_reading_book'],
            'second_reading_body' => $reading['second_reading_body'],


            'responsorial_psalm_title' => $reading['responsorial_title'],
            'responsorial_psalm_verse' => $reading['responsorial_book'],
            'responsorial_psalm_body_one' => $reading['responsorial_body_one'],
            'responsorial_psalm_body_two' => $reading['responsorial_body_two'],

            'gospel_title'      => $reading['gospel_title'],
            'gospel_body'      => $reading['gospel_body'],


        ];
    }

} 