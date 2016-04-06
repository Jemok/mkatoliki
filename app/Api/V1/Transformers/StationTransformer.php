<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:27 PM
 */

namespace App\Api\V1\Transformers;


class StationTransformer extends Transformer {

    public function transform($station)
    {
        return [

            'id'           => $station['id'],
            'station_name'  => $station['station_name'],
            'parish_id'     => $station['parish_id']
        ];
    }

} 