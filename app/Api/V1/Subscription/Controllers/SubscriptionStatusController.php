<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/1/16
 * Time: 8:46 AM
 */

namespace App\Api\V1\Subscription\Controllers;


use App\Api\V1\Subscription\Models\SubscriptionStatus;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class SubscriptionStatusController extends Controller {

    /**
     * The Dingo API helpers
     */
    use Helpers;

    /**
     * Handle persisting of a new Subscription status to the database
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(Request $request){

        $subscription_status = new SubscriptionStatus;

        $subscription_status->status_name = $request->get('status_name');
        $subscription_status->status_code = $request->get('status_code');

        if($this->currentUser()->subscription_status()->save($subscription_status))
            return $this->response->created();
        else
            return $this->response->error('Could not create subscription status', 500);
    }

} 