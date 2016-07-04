<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/4/16
 * Time: 12:28 PM
 */

namespace App\Observers;

use App\Api\V1\GCM\Models\GcmPushType;
use App\Api\V1\GCM\Models\Phone_token;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use App\Api\V1\GCM\Repositories\GcmPushRepository;
use App\Api\V1\Account\Models\User_stations;


class GroupObserver {

    /**
     * List of phone tokens
     * @var array
     */
    protected   $phone_tokens;

    protected   $user_id = [];


    /**
     *
     * @param $model
     */
    public function saved($model){

        $station_id = $model->station_id;

        $user_ids = User_stations::where('station_id', $station_id)->get(['user_id']);

        foreach($user_ids as $id){

            $this->user_id[] = $id->user_id;
        }

        $tokens = Phone_token::whereIn('user_id', $this->user_id)->get(['token']);


        $this->push($tokens);
    }

    public function push($to){

        $client = new Client(['timeout'  => 60.0]);

        //var_dump($to);

        foreach($to as $t){

            $this->phone_tokens[] = $t->token;
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
                        'registration_ids'   => $this->phone_tokens,
                        'data' => [
                            'message' => 'sync',
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