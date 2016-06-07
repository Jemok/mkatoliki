<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/1/16
 * Time: 10:47 AM
 */

namespace App\Api\V1\Subscription\Services;
use App\Api\V1\Subscription\Models\Subscription;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
use App\Api\V1\Subscription\Models\SubscriptionDetail;
use App\Api\V1\Subscription\Models\SubscriptionMpesaResults;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;

use App\Api\V1\Subscription\Models\SubscriptionMpesaConfirmations;

ini_set("soap.wsdl_cache_enabled", "0");

class MpesaClient {

    /**
     * Mpesa API production end point
     * @var string
     */
    protected $mpesa_url = "https://www.safaricom.co.ke/mpesa_online/lnmo_checkout_server.php?wsdl";

    public function processCheckOutRequest($password,$MERCHANT_ID,$MERCHANT_TRANSACTION_ID,$REFERENCE_ID,$AMOUNT,$MSISDN,$CALL_BACK_URL, $subscription_id, $subscription_status_code)
    {
    $TIMESTAMP = new \DateTime();

    $datetime = $TIMESTAMP->format('YmdHis');

    $post_string='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tns="tns:ns">
                   <soapenv:Header>
                        <tns:CheckOutHeader>
                            <MERCHANT_ID>'.$MERCHANT_ID.'</MERCHANT_ID>
                            <PASSWORD>'.$password.'</PASSWORD>
                            <TIMESTAMP>'.$datetime.'</TIMESTAMP>
                        </tns:CheckOutHeader>
                   </soapenv:Header>
                   <soapenv:Body>
                        <tns:processCheckOutRequest>
                            <MERCHANT_TRANSACTION_ID>'.$MERCHANT_TRANSACTION_ID.'</MERCHANT_TRANSACTION_ID>
                            <REFERENCE_ID>'.$REFERENCE_ID.'</REFERENCE_ID>
                            <AMOUNT>'.$AMOUNT. '</AMOUNT>
                            <MSISDN>'.$MSISDN.'</MSISDN>

                            <!--Optional parameters-->
                            <CALL_BACK_URL>'.$CALL_BACK_URL.'</CALL_BACK_URL>
                            <CALL_BACK_METHOD>POST</CALL_BACK_METHOD>
                            <TIMESTAMP>'.$datetime.'</TIMESTAMP>
                        </tns:processCheckOutRequest>
                   </soapenv:Body>
                   </soapenv:Envelope>';

                   /**
                    * SOAP checkOutRequest headers
                    */

                    $headers = [

                        "Content-type: text/xml",
                        "Content-length: ".strlen($post_string),
                        "Content-transfer-encoding: text",
                        "Connection: Keep-Alive",
                        "Expect:",
                        "SOAPAction: \"processCheckOutRequest\"",
                    ];
               /**
                * To get the feedback from the process request system
                *
                *  For debug purpose only
                */

                try{
                        $response = $this->submitRequest($this->mpesa_url, $post_string, $headers);

                        $xml = simplexml_load_string($response);
                        $ns = $xml->getNamespaces(true);
                        $soap = $xml->children($ns['SOAP-ENV']);
                        $sbody = $soap->Body;
                        $mpesa_response = $sbody->children($ns['ns1']);
                        $rstatus = $mpesa_response->processCheckOutResponse;
                        $status = $rstatus->children();
                        $returncode = $status->RETURN_CODE;
                        $description = $status->DESCRIPTION;
                        $transaction_id = $status->TRX_ID;
                        $encryptionparams = $status->ENC_PARAMS;
                        $customer_message = $status->CUST_MSG;

                        //Save subscription mpesa request here

//                        $confirm_response = $this->confirmTransaction($transaction_id, $datetime, $password, $MERCHANT_ID, $gcmPushService);

                        $response = [

                            'subscription_status' => $subscription_status_code,
                            'status_description' => 'initiated',
                            'subscription_id'   => $subscription_id,
                            'transaction_id' => "cce3d32e0159c1e62a9ec45b67676200",//$transaction_id,
                            'message' =>  "To complete this transaction, enter your Bonga PIN on your handset. if you don't have one dial *126*5# for instructions"//$customer_message
                        ];

                        return $response;

                        }catch(RequestException $e){

                            return "Failed to execute";

                        }
    }

    /**
     * Merchant makes a SOAP call to the SAG to confirm an online checkout transaction
     */

    public function confirmTransaction($transaction_id, $datetime, $password, $MERCHANT_ID, $subscription_id, $gcmPushService){
        $confirmTransactionResponse='
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tns="tns:ns">
             <soapenv:Header>
                <tns:CheckOutHeader>
                    <MERCHANT_ID>'.$MERCHANT_ID.'</MERCHANT_ID>
                    <PASSWORD>'.$password.'</PASSWORD>
                    <TIMESTAMP>'.$datetime.'</TIMESTAMP>
                </tns:CheckOutHeader>
             </soapenv:Header>
             <soapenv:Body>
                <tns:transactionConfirmRequest>
                    <!--Optional-->
                    <TRX_ID>'.$transaction_id.'</TRX_ID>
                    <!--Optional:-->
                </tns:transactionConfirmRequest>
             </soapenv:Body>
        </soapenv:Envelope>';

        $headers = [
            "Content-type: text/xml",
            "Content-length: ".strlen($confirmTransactionResponse),
            "Content-transfer-encoding: text",
            "SOAPAction: \"transactionConfirmRequest\"",
        ];

        $confirm_response = $this->submitRequest($this->mpesa_url, $confirmTransactionResponse, $headers);

        $xml = simplexml_load_string($confirm_response);
        $ns = $xml->getNamespaces(true);
        $soap = $xml->children($ns['SOAP-ENV']);
        $sbody = $soap->Body;
        $mpesa_response = $sbody->children($ns['ns1']);
        $rstatus = $mpesa_response->transactionConfirmResponse;
        $status = $rstatus->children();
        $s_returncode = $status->RETURN_CODE;
        $s_description = $status->DESCRIPTION;
        $s_merchant_transactionid = $status->MERCHANT_TRANSACTION_ID;
        $s_transactionid = $status->TRX_ID;

        SubscriptionMpesaConfirmations::create([
            'trasnsaction_id' => "cce3d32e0159c1e62a9ec45b67676200",//$s_transactionid,
            'return_code'    => $s_returncode,
            'description'    => $s_description,
            'merchant_transaction_id' => $s_merchant_transactionid,
            'subscription_id'    => $subscription_id
        ]);


        $subscription = Subscription::where('id', '=', $subscription_id)->first();

        $subscription_status = SubscriptionStatus::where('status_code', '=', 3)->first();

        $subscription->update([

            'subscription_status_id' => $subscription_status->id
        ]);

        return $response = [

            'subscription_status' => $subscription_status->status_code,
            'status_description' => 'confirmed',
            'subscription_id'   => $subscription_id,
            'transaction_id'      => "cce3d32e0159c1e62a9ec45b67676200"//$transaction_id
        ];
    }

    public function transactionStatusRequest($password,$MERCHANT_ID, $TRX_ID, $MERCHANT_TRANSACTION_ID, $subscription_id){

        $TIMESTAMP = new \DateTime();

        $datetime = $TIMESTAMP->format('YmdHis');

        $post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tns="tns:ns">
                   <soapenv:Header>
                        <tns:CheckOutHeader>
                            <MERCHANT_ID>'. $MERCHANT_ID. '</MERCHANT_ID>
                            <PASSWORD>'. $password . ' </PASSWORD>
                            <TIMESTAMP>' . $datetime . ' </TIMESTAMP>
                        </tns:CheckOutHeader>
                   </soapenv:Header>
                   <soapenv:Body>
                        <tns:transactionStatusRequest>
                                   <!--Optional:-->
                                     <TRX_ID>'.$TRX_ID.'</TRX_ID>
                                   <!--Optional:-->
                                    <MERCHANT_TRANSACTION_ID>'.$MERCHANT_TRANSACTION_ID.'</MERCHANT_TRANSACTION_ID>
                        </tns:transactionStatusRequest>
                   </soapenv:Body>
                   </soapenv:Envelope>';


        $headers = [
            "Content-type: text/xml",
            "Content-length: ".strlen($post_string),
            "Content-transfer-encoding: text",
            "Connection: Keep-Alive",
            "Expect:",
            "SOAPAction: \"transactionStatusRequest\"",
        ];

        try{
            $response = $this->submitRequest($this->mpesa_url, $post_string, $headers);

            $xml = simplexml_load_string($response);
            $ns = $xml->getNamespaces(true);
            $soap = $xml->children($ns['SOAP-ENV']);
            $sbody = $soap->Body;
            $mpesa_response = $sbody->children($ns['ns1']);
            $rstatus = $mpesa_response->transactionStatusResponse;
            $status = $rstatus->children();
            $phone_number = $status->MSISDN;
            $amount = $status->AMOUNT;
            $mpesa_transaction_date = $status->MPESA_TRX_DATE;
            $mpesa_transaction_id = $status->MPESA_TRX_ID;
            $returncode = $status->RETURN_CODE;
            $description = $status->DESCRIPTION;
            $merchant_transaction_id = $status->MERCHANT_TRANSACTION_ID;
            $transaction_id = $status->TRX_ID;
            $encryptionparams = $status->ENC_PARAMS;

            $mpesa_confirmation = SubscriptionMpesaConfirmations::where('trasnsaction_id', $transaction_id)->first();

            //dd($mpesa_confirmation);

            $mpesa_confirmation_id = $mpesa_confirmation->id;

            $subscription_id = $mpesa_confirmation->subscription_id;

            $mpesa_results = SubscriptionMpesaResults::create([
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

        }catch(RequestException $e){

            return "Failed to execute";

        }
    }

    /**
     * @param $url
     * @param $post_string
     * @param $headers
     * @return mixed
     */

    function submitRequest($url, $post_string, $headers){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($ch);

        if($data === FALSE){

            $err = 'Curl error:' . curl_error($ch);
            curl_close($ch);

            echo "Error \n".$err;
        }else{
            curl_close($ch);

            return $data;
        }
    }
} 