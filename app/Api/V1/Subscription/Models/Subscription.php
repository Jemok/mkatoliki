<?php

namespace App\Api\V1\Subscription\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Subscription extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'subscriptions';

    protected $fillable = [

        'subscription_category_id',
        'user_id',
        'subscription_status_id',
    ];

    /**
     * Subscription -- User Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * Subscription -- SubscriptionDetail Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription_details(){

        return $this->hasOne(SubscriptionDetail::class);
    }

    /**
     * Subscription -- SubscriptionCategory Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription_category(){

        return $this->belongsTo(SubscriptionCategory::class);
    }

    /**
     * Subscription -- SubscriptionStatus Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription_status(){

        return $this->belongsTo(SubscriptionStatus::class);
    }

    /**
     * Subscription -- SubscriptionMpesaResults
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription_mpesa(){

        return $this->hasOne(SubscriptionMpesaResults::class);
    }

    /**
     * Subscription -- SubscriptionMpesaConfirmations Results
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription_mpesa_confirmation(){

        return $this->hasOne(SubscriptionMpesaConfirmations::class);
    }

    public static function boot(){

        parent::boot();

        Subscription::observe(new GlobalObserver());
    }
}
