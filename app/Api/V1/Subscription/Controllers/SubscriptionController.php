<?php

namespace App\Api\V1\Subscription\Controllers;

use App\Api\V1\Subscription\Models\SubscriptionCategory;
use App\Api\V1\Subscription\Models\SubscriptionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Api\V1\Subscription\Services\MpesaClient;
use App\Api\V1\GCM\Services\GcmPushService;
use App\Api\V1\Subscription\Models\SubscriptionMpesaConfirmations;
use App\Api\V1\Subscription\Models\SubscriptionMpesaResults;
use App\Api\V1\Subscription\Models\Subscription;
use App\Api\V1\Subscription\Models\SubscriptionStatus;

class SubscriptionController extends Controller
{
    /**
     * The merchant id from Mpesa
     * @var string
     */
    protected $MERCHANT_ID = "123";

    /**
     * The merchant transaction id from mpesa
     * @var string
     */
    protected $MERCHANT_TRANSACTION_ID = "456";

    /**
     * The pass key for our Mpesa account
     * @var string
     */
    protected $PASSKEY = "*mkatoliki#";


    /**
     * Mpesa Cert location
     * @var string
     */
    protected $cert_location = "";

    /**
     * The call back url that we will give to mpesa
     * @var string
     */
    protected $callback_url = "api.mkatoliki.com/mpesa";


    /**
     * Dingo API routing helpers
     */

    use Helpers;

    /**
     * Handle persisting of a new subscription to the database
     * @param Request $request
     */
    public function store(Request $request, MpesaClient $mpesaClient){

        $subscription_category_code = $request->get('subscription_category_code');

        $customer_phone_number = $request->get('phone_number');

        $subscription_category_model = new SubscriptionCategory;

        $subscription_category = $subscription_category_model
                                    ->where('subscription_category', '=', $subscription_category_code)
                                    ->first();

        $reference_id = $subscription_category->id;

        $amount = $subscription_category->price;

        $subscription_status = SubscriptionStatus::where('status_code', '=', 2)->first();

        $subscription_status_code = $subscription_status->status_code;

        $subscription_status_id = $subscription_status->id;

        $subscription = Subscription::create([

            'subscription_category_id' => $reference_id,
            'user_id'   => \Auth::user()->id,
            'subscription_status_id' => $subscription_status_id,
            'subscription_id' => 1
        ]);

        //Initiate M-pesa  processCheckout Interface at this point

        $password = $this->generateMpesaHashPassword();

        $result = $mpesaClient->processCheckOutRequest($password, $this->MERCHANT_ID, $this->MERCHANT_TRANSACTION_ID, $reference_id, $amount, $customer_phone_number, $this->callback_url, $subscription->id, $subscription_status_code);

        if($result != false){

            return $result;
        }

        return 'error';

    }

    public function confirmTransaction(Request $request, MpesaClient $mpesaClient, GcmPushService $gcmPushService){

        $transaction_id = $request->get('transaction_id');

        $subscription_id = $request->get('subscription_id');

        $TIMESTAMP = new \DateTime();

        $datetime = $TIMESTAMP->format('YmdHis');

        $password = $this->generateMpesaHashPassword();

        return $mpesaClient->confirmTransaction($transaction_id, $datetime, $password, $this->MERCHANT_ID, $subscription_id, $gcmPushService);

    }

    public function finishTransaction(Request $request){

        $mpesa_results = new SubscriptionMpesaResults();

        $transaction_id = $request->get('transaction_id');

        $subscription_id = $request->get('subscription_id');

        if($mpesa_results->where('transaction_id', '=', $transaction_id)
//                       ->where('subscription_id', '=', $subscription_id)
                         ->first()->transaction_id == $transaction_id){

           $mpesa_results = $mpesa_results->where('transaction_id', '=', $transaction_id)
                ->where('subscription_id', '=', $subscription_id)
                ->first();

            if($mpesa_results->transaction_status == 'Pending'){

                return $response = [

                    'message' => 'Pending',
                    'reason' => $mpesa_results->description
                ];
            }elseif($mpesa_results->transaction_status == 'success'){

                $subscription_status_id = SubscriptionStatus::where('status_code', '=', 0)->first()->id;

                $subscription = Subscription::where('id', '=', $subscription_id)->first();

                $subscription_category_id = $subscription->subscription_category_id;

                $subscription_days = SubscriptionCategory::where('id', '=', $subscription_category_id)->first()->days;

                $start_date = Carbon::now();

                $end_date = Carbon::now()->addDays($subscription_days);

                SubscriptionDetail::create([

                    'start_date' => $start_date,
                    'end_date'   => $end_date

                ]);

                $subscription->update([
                    'subscription_status_id' => $subscription_status_id
                ]);

                $response = [
                    'subscription_id' => $subscription_id,
                    'subscription_status' => 0,
                    'subscription_description' => 'active',
                    'message' => 'Success',
                    'user_id'   => \Auth::user()->id,
                    'subscription_days' => $subscription_days,
                    'start_date' => $start_date,
                    'end_date'   => $end_date
                ];

                return $response;


            }elseif($mpesa_results->transaction_status == 'Failed'){

                return $response = [
                   'message' => 'Failed',
                   'reason' => $mpesa_results->description
                ];
            }elseif($mpesa_results->transaction_status == 'Error'){

                return $response = [
                    'message' => 'Failed',
                    'reason' => $mpesa_results->description

                ];
            }

        }else{
            return $response = [

                'status_code' => 100,
                'message' => 'Transaction is being processed by mpesa'

            ];
        }
    }

    public function saveMpesaResults(Request $request){

        $phone_number = $request->get('MSISDN');

        $trasnsaction_amount = $request->get('AMOUNT');

        $transaction_date = $request->get('M-PESA_TRX_DATE');

        $mpesa_transaction_id = $request->get('M-PESA_TRX_ID');

        $transaction_id = $request->get('TRX_ID');

        $transaction_status = $request->get('TRX_STATUS');

        $return_code = $request->get('RETURN_CODE');

        $description = $request->get('DESCRIPTION');

        $mpesa_confirmation = SubscriptionMpesaConfirmations::where('trasnsaction_id', $transaction_id)->first();

        //dd($mpesa_confirmation);

        $mpesa_confirmation_id = $mpesa_confirmation->id;

        $subscription_id = $mpesa_confirmation->subscription_id;

        SubscriptionMpesaResults::create([
            'phone_number' =>  "254712675071",//$phone_number,
            'transaction_amount' => 50,//$trasnsaction_amount,
            'transaction_date'  => Carbon::now(),//$transaction_date,
            'mpesa_transaction_id' => "1234567",//$mpesa_transaction_id,
            'transaction_status'   => "Success",//$transaction_status,
            'description' => "cool",//$description,
            'return_code'       => "00",//$return_code,
            'transaction_id' =>   $transaction_id,
            'mpesa_confirmation_id' => $mpesa_confirmation_id,
            'subscription_id'       => $subscription_id
        ]);

        return 'ok';
    }

    public function cancelSubscription(Request $request){

        $subscription_id = $request->get('subscription_id');

        $transaction_id = $request->get('transaction_id');

        $subscription = Subscription::findOrFail($subscription_id);

        $subscription_status = SubscriptionStatus::where('status_code', '=', 4)->first();

        $subscription_status_id = $subscription_status->id;

        $subscription->update([

            'subscription_status_id' => $subscription_status_id

        ]);

        $response = [

            'subscription_id' => $subscription_id,
            'transaction_id' => $transaction_id,
            'subscription_status' => 4,
            'subscription_description' => 'canceled',
            'cancellation_date'  => Carbon::now()

        ];

        return $response;
    }

    public function generateMpesaHashPassword(){

        $TIMESTAMP = new \DateTime();

        $datetime = $TIMESTAMP->format('YmdHis');

        return base64_encode(hash("sha256", $this->MERCHANT_ID.$this->PASSKEY.$datetime));
    }

    public function queryMpesa(Request $request, MpesaClient $mpesaClient){

        $password = $this->generateMpesaHashPassword();

        $transaction_id = $request->get('transaction_id');

        $subscription_id = $request->get('subscription_id');

        return $mpesaClient->transactionStatusRequest($password, $this->MERCHANT_ID, $transaction_id, $this->MERCHANT_TRANSACTION_ID, $subscription_id);
    }
}
