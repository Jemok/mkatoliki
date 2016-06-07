<?php

namespace App\Api\V1\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionMpesaConfirmations extends Model
{
    /**
     * Table used by this model
     * @var string
     */
    protected $table = "subscription_mpesa_confirmations";

    /**
     * Fields that may be mass assigned
     * @var array
     */
    protected $fillable = [

        'trasnsaction_id',
        'return_code',
        'description',
        'merchant_transaction_id',
        'subscription_id',
    ];

    /**
     * SubscriptionMpesaConfirmations -- Subscription Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(){

        return $this->belongsTo(Subscription::class);
    }

    /**
     * SubscriptionMpesaConfirmations -- SubscriptionMpesaResults  Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription_mpesa_results(){

        return $this->hasOne(SubscriptionMpesaResults::class, 'mpesa_confirmation_id');
    }
}
