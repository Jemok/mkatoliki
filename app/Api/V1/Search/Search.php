<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/6/16
 * Time: 6:00 PM
 */

namespace App\Api\V1\Search;


use App\Api\V1\Station\Models\Station;

class Search {

    public function stations($search){

        return Station::search($search)->get()->toArray();
    }

} 