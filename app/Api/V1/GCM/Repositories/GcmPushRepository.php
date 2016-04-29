<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/27/16
 * Time: 1:46 PM
 */

namespace App\Api\V1\GCM\Repositories;
use App\Api\V1\GCM\Models\GcmPush;

class GcmPushRepository {

    /**
     * Persist the google message_id to db
     * @param $message_id
     */

    public function store($message_id){
        GcmPush::create([
            'message_id' => $message_id
        ]);
    }

} 