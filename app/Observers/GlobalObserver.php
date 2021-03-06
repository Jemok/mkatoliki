<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/26/16
 * Time: 1:15 PM
 */

namespace App\Observers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Api\V1\GCM\Repositories\GcmPushRepository;
use App\Api\V1\GCM\Models\GcmPushType;

class GlobalObserver {
    /**
     *
     * @param $model
     */
    public function saved($model){
        $this->push();
    }

    /**
     * Push a global message to all phones using GCM
     */
    public function push(){
        $client = new Client(['timeout'  => 300.0]);

        try{
            $response = $client->post('https://fcm.googleapis.com/fcm/send',
                [
                    'headers' => [
                        'User-Agent' => 'MkatolikiApp',
                        'Authorization' => 'key=AIzaSyCAGRXrBB__ZhlQIV0thCY7zM2AziWbIcY',
                        'Content-Type'     => 'application/json'
                    ],
                    'json' => [
                        'to'   => '/topics/global',
                        'data' => [
                            'message' => 'sync'
                        ]
                    ]
                ]);

            $body = $response->getBody();

            $json_message = $body->getContents();

            $message = json_decode($json_message);

            $gcm_repository = new GcmPushRepository();

            $gcm_push_type_id = GcmPushType::where('type_code', '=', 2)->first()->id;

            $gcm_repository->store($message->message_id,"","", "", "", "", $gcm_push_type_id);

        }catch (RequestException $e){
        }
    }
} 