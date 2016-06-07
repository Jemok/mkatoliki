<?php

namespace App\Api\V1\Subscription\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class SubscriptionCategory extends Model
{
    /**
     * The table associated by this model
     * @var string
     */
    protected $table = 'subscription_categories';

    /**
     * The fields that may be mass assigned
     * @var array
     */
    protected $fillable = [

        'name',
        'days',
        'price',
        'subscription_category'
    ];

    /**
     *  SubscriptionCategory -- User Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * SubscriptionCategory -- Subscription Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(){

        return $this->hasMany(Subscription::class);
    }
}
