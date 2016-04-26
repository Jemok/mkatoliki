<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/26/16
 * Time: 1:15 PM
 */

namespace App\Observers;
use App\Reading;
use GuzzleHttp\Client;


class GlobalObserver {

    public function saved($model){

        $client = new Client();


        $client->post('https://gcm-http.googleapis.com/gcm/send',
        [
           "headers" => [
               "Authorization" => "key=AIzaSyCAGRXrBB__ZhlQIV0thCY7zM2AziWbIcY",
               "Content-Type"     => "application/json"
           ],
            [
                "to"   => "/topics/global",
                "data" => [
                    "message" => "update"
             ]
        ]
        ]);
    }

    public function deleted($model) {

    }
} 