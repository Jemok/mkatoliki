<?php

namespace App\Api\V1\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\SubscriptionMpesaObserver;

class SubscriptionMpesaResults extends Model
{
    /**
     * Table used by this model
     * @var string
     */
    protected $table = "subscription_mpesa_results";

    /**
     * Fields that may be mass assigned
     * @var array
     */
    protected $fillable = [
        'phone_number',
        'transaction_amount',
        'transaction_date',
        'transaction_id',
        'transaction_status',
        'return_code',
        'description',
        'mpesa_confirmation_id',
        'subscription_id'

    ];

    /**
     * SubscriptionMpesaResults belongs to a subscription
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(){

        return $this->belongsTo(Subscription::class);
    }

    /**
     * SubscriptionMpesaResults -- SubscriptionMpesaConfirmations Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription_mpesa_confirmation(){

        return $this->belongsTo(SubscriptionMpesaConfirmations::class);
    }

    public static  function boot(){

        parent::boot();

        SubscriptionMpesaResults::observe(new SubscriptionMpesaObserver());
    }
}
