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

    protected $s = [];

    /**
     * Push a global message to all phones using GCM
     */
    public function push($to, $message, $title){
        $client = new Client(['timeout'  => 60.0]);

        //var_dump($to);

        foreach($to as $t){

            $this->s[] = $t->token;
        }

        try{
            $response = $client->post('https://fcm.googleapis.com/fcm/send',
            [
                    'headers' => [
                        'User-Agent' => 'MkatolikiApp',
                        'Authorization' => 'key=AIzaSyCAGRXrBB__ZhlQIV0thCY7zM2AziWbIcY',
                        'Content-Type'     => 'application/json'
                    ],


                    'json' => [
                        'registration_ids'   => $this->s,
                        'notification' => [
                            'title' => $title,
                            'text'  => $message
                        ]
                    ]
            ]);



            $body = $response->getBody();

            $json_message = $body->getContents();

            $message = json_decode($json_message);

            //dd($message->results);

            //type code 1 for personal/notification
            //typecode 2 for global sync
            //typecode 3 for group sync

            $gcm_push_type_id = GcmPushType::where('type_code', '=', 1)->first()->id;

            $gcm_repository = new GcmPushRepository();

            $gcm_repository->store("",$message->results, $message->multicast_id, $message->success, $message->failure, $message->canonical_ids, $gcm_push_type_id);

        }catch (RequestException $e){

        }
    }



} 