<?php

namespace App\Api\V1\Subscription\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class SubscriptionStatus extends Model
{
    /**
     * This model table
     * @var string
     */
    protected $table = 'subscription_status';

    /**
     * All the fields that may be mass assigned
     * @var array
     */
    protected $fillable = [

        'status_name',
        'status_code'
    ];


    /**
     * SubscriptionStatus -- User Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * SubscriptionStatus -- Subscription Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(){

        return $this->hasMany(Subscription::class);
    }
}
