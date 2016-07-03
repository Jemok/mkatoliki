<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/3/16
 * Time: 8:15 AM
 */

namespace App\Api\V1\Announcement\Transformers;


use App\Api\V1\Transformers\Transformer;

class AnnouncementTransformer extends Transformer {

    public function transform($announcement){

        return [
            'id'                => $announcement['id'],
            'title'  => $announcement['title'],
            'announcement' => $announcement['announcement'],
            'date'         => $announcement['date'],
            'station_id'   => $announcement['station_id']
        ];

    }

} 