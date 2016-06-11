<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/1/16
 * Time: 7:58 AM
 */

namespace App\Api\V1\Subscription\Controllers;


use App\Api\V1\Account\Models\User;
use App\Api\V1\Subscription\Models\Subscription;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
use App\Api\V1\Subscription\Transformers\SubscriptionTransformer;
use App\Http\Controllers\Controller;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class SubscriptionCategoryController extends Controller {

    /**
     * The Dingo Api Routing Helpers;
     */
    use Helpers;

    /**
     * Handle Persisting of a new Subscription to the database
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(Request $request){

        $subscription_category = new SubscriptionCategory;

        $subscription_category->name = $request->get('name');
        $subscription_category->days = $request->get('days');
        $subscription_category->price = $request->get('price');
        $subscription_category->subscription_category = $request->get('subscription_category');

        if($this->currentUser()->subscription_categories()->save($subscription_category))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_subscription_category', 500);
    }

    public function getSubscriptions(SubscriptionTransformer $subscriptionTransformer){



        $users =  User::where('id', '=', \Auth::user()->id)->get()->toArray();

        return $this->respond($subscriptionTransformer->transformCollection($users));
    }

    public function subscribe(Request $request){

        $user_id = $request->get('user_id');

        $subscription_category = SubscriptionCategory::where('subscription_category', 2)->first();
        $subscription_status = SubscriptionStatus::where('status_code', 0)->first();

        $subscription = Subscription::create([
            'user_id' => $user_id,
            'subscription_category_id' => $subscription_category->id,
            'subscription_status_id'   => $subscription_status->id,
        ]);

        $subscription->subscription_details()->create([

            'start_date'    => Carbon::now(),
            'end_date'      => Carbon::now()->addDays($subscription_category->days)

        ]);

//        $subscription_id = $request->get('subscription_id');
//
//        $subscription = Subscription::where('user_id', $user_id)->where('id', $subscription_id)->first();
//
//        $subscription_status = SubscriptionStatus::where('status_code', 0)->first();
//
//        $subscription->update([
//            'subscription_status_id' => $subscription_status->id
//        ]);
    }

    public function unSubscribe(Request $request){

        $user_id = $request->get('user_id');

        $subscription_id = $request->get('subscription_id');

        $subscription = Subscription::where('user_id', $user_id)->where('id', $subscription_id)->first();

        $subscription_status = SubscriptionStatus::where('status_code', 1)->first();

        $subscription->update([
            'subscription_status_id' => $subscription_status->id
        ]);
    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, '200', $headers);
    }
} 