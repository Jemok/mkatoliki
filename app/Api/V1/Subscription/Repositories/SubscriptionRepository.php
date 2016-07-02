<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/2/16
 * Time: 7:51 AM
 */

namespace App\Api\V1\Subscription\Repositories;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
use Carbon\Carbon;


class SubscriptionRepository {

    /**
     * Create a new default subscription category for the authenticated user
     * @param $user
     * @return mixed
     */
    public function defaultSubscription($user){

       $subscription = $user->subscriptions()->create([
            'subscription_category_id' => SubscriptionCategory::where('subscription_category', 2)->first()->id,
            'subscription_status_id' => SubscriptionStatus::where('status_code', 1)->first()->id
        ]);

        $this->setSubscriptionDetails($subscription);

    }

    /**
     * Set the details of the subscription
     * @param $subscription
     */
    private  function setSubscriptionDetails($subscription){

        $subscription->subscription_details()->create([
            'start_date' => Carbon::now(),
            'end_date'   => Carbon::now()->addHours(SubscriptionCategory::where('subscription_category', 1)->first()->days)
        ]);

    }

} 