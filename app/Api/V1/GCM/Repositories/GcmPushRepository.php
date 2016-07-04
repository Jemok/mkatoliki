<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/27/16
 * Time: 1:46 PM
 */

namespace App\Api\V1\GCM\Repositories;
use App\Api\V1\GCM\Models\GcmPush;
use App\GcmMessages;

class GcmPushRepository {

    /**
     * Persist the google message push response to db
     * @param $messages
     * @param $multicast_id
     * @param $success
     * @param $failure
     * @param $canonical_ids
     * @param $gcm_push_type_id
     */
    public function store($message_id, $messages, $multicast_id, $success, $failure, $canonical_ids, $gcm_push_type_id){
        $gcm_push = GcmPush::create([
            'message_id' => $message_id,
            'success' => $success,
            'failure' => $failure,
            'multicast_id' => $multicast_id,
            'conical_ids' => $canonical_ids,
            'gcm_push_type_id' => $gcm_push_type_id,
        ]);


        if(!$message_id){
            $this->storeGcmPushMessages($messages, $gcm_push);
        }
    }

    /**
     * Store the gcm_messages for a single push
     * @param $messages
     * @param $gcm_push
     */
    private function storeGcmPushMessages($messages, $gcm_push){

        foreach($messages as $message){

            $gcm_push->gcm_messages()->create([
               'message_id' => $message->message_id
            ]);

        }
    }
} 