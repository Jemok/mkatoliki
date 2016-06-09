<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/1/16
 * Time: 2:18 PM
 */

namespace App\Api\V1\GCM\Services;
use App\Api\V1\GCM\Models\GcmPushType;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use App\Api\V1\GCM\Repositories\GcmPushRepository;


class GcmPushService {

    /**
     * Push a global message to all phones using GCM
     */
    public function push($to, $message){
        $client = new Client(['timeout'  => 60.0]);

        try{
            $response = $client->post('https://gcm-http.googleapis.com/gcm/send',
            [
                    'headers' => [
                        'User-Agent' => 'MkatolikiApp',
                        'Authorization' => 'key=AIzaSyCAGRXrBB__ZhlQIV0thCY7zM2AziWbIcY',
                        'Content-Type'     => 'application/json'
                    ],
                    'json' => [
                        'to'   => $to,
                        'data' => [
                            'message' => $message
                        ]
                    ]
            ]);

            $body = $response->getBody();

            $json_message = $body->getContents();

            $message = json_decode($json_message);

            //type code 1 for personal
            //typecode 2 for global

            $gcm_push_type_id = GcmPushType::where('type_code', '=', 1)->first()->id;

            $gcm_repository = new GcmPushRepository();

            $gcm_repository->store($message->results[0]->message_id, $message->multicast_id, $message->success, $message->failure, $message->canonical_ids, $gcm_push_type_id);

        }catch (RequestException $e){

        }
    }

} 