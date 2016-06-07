<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/1/16
 * Time: 5:09 PM
 */

namespace App\Api\V1\GCM\Repositories;

use App\Api\V1\GCM\Models\GcmPushType;

class GcmPushTypeRepository {

    /**
     * Persist a GcmPush Type to db
     */
    public function store(){

        GcmPushType::create([

            'type_name',
            'type_code'
        ]);
    }

} 