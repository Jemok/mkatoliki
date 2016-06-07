<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/2/16
 * Time: 2:06 PM
 */

namespace App\Observers;
use App\Api\V1\GCM\Models\Phone_token;
use App\Api\V1\Subscription\Models\Subscription;
use App\Api\V1\GCM\Services\GcmPushService;


class SubscriptionMpesaObserver {

    public function saved($model){

        $this->handle(new GcmPushService(), $model);

    }

    public function handle(GcmPushService $gcmPushService, $model){

        $transaction_status = $model->transaction_status;

        if($transaction_status == 'Success'){

            $message = 'Your subscription was successful!'; //$model->description
        }elseif($transaction_status == 'Failed'){

            $message = 'Your subscription failed!'; // $model->description
        }elseif($transaction_status == 'Pending'){

            $message = 'Your ubscription is pending'; // $model->description;
        }elseif($transaction_status == 'Error'){

            $message = 'Your subscription failed'; // $model->description ;

        }else{

            $message = "Sorry we could not complete transaction";
        }

        $user_id = Subscription::where('id', '=', $model->subscription_id)->first()->user_id;

        $to = Phone_token::where('user_id', '=', $user_id)->first()->token;

        $gcmPushService->push($to, $message);
    }

} 