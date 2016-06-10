<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/1/16
 * Time: 7:58 AM
 */

namespace App\Api\V1\Subscription\Controllers;


use App\Api\V1\Account\Models\User;
use App\Api\V1\Subscription\Transformers\SubscriptionTransformer;
use App\Http\Controllers\Controller;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
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

        $users =  User::where('id', '>', 20)->get()->toArray();

        return $this->respond($subscriptionTransformer->transformCollection($users));
    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, '200', $headers);
    }
} 