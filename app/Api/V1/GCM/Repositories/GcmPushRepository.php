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
     * Persist the google message push response to db
     * @param $message_id
     * @param $success
     * @param $failure
     * @param $canonical_ids
     * @param $gcm_push_type_id
     */
    public function store($message_id, $multicast_id, $success, $failure, $canonical_ids, $gcm_push_type_id){
        GcmPush::create([
            'message_id' => $message_id,
            'success' => $success,
            'failure' => $failure,
            'multicast_id' => $multicast_id,
            'conical_ids' => $canonical_ids,
            'gcm_push_type_id' => $gcm_push_type_id,

        ]);
    }

} 