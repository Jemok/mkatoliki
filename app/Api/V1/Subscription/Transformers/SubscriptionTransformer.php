<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 6/10/16
 * Time: 4:56 PM
 */

namespace App\Api\V1\Subscription\Transformers;


use App\Api\V1\Account\Models\User;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
use App\Api\V1\Transformers\Transformer;

class SubscriptionTransformer extends Transformer {

    public function transform($user)
    {

        $user = User::where('id', $user['id'])->with('subscriptions')->first();


        $subscription_status_id = $user->subscriptions->last()->subscription_status_id;

        $old_subscription_status_id = SubscriptionStatus::where('status_code', 1)->first();

        $oldSubscriptions = $user->subscriptions()->where('subscription_status_id', $old_subscription_status_id)->get();

        $oldSubscription = $oldSubscriptions->last();


        if($user->subscriptions()->where('subscription_status_id', $subscription_status_id)->exists()){

            $subscription = $user->subscriptions()->where('subscription_status_id', $subscription_status_id)->first();

            return [
                'name'   => $user->name,
                'email'  => $user->email,
                'phone_number' => $user->phone_number,
                'subscription_id' => $subscription->id,
                'user_id' => $user->id,
                'subscription_status' =>  $subscription->subscription_status->status_code,
                'subscription_category_name' => $subscription->subscription_category->name,
                'subscription_category_code' => $subscription->subscription_category->subscription_category,
                'start_date' => $subscription->subscription_details->start_date,
                'end_date' => $subscription->subscription_details->end_date,
                'created_at' => $subscription->created_at,
                'updated_at' => $subscription->updated_at,
                'closed_subscription_id' => $oldSubscription->id
            ];
        }

        return [
            'message' => 'no subscriptions'
        ];


    }

} 