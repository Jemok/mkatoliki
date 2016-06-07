<?php

namespace App\Api\V1\Subscription\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class SubscriptionDetail extends Model
{
    /**
     * Table associated by this model
     * @var string
     */
    protected $table = 'subscription_details';

    /**
     * The fields tha might be mass assigned
     * @var array
     */
    protected $fillable = [

        'start_date',
        'end_date'
    ];


    /**
     * SubscriptionDetail -- Subscription Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(){

        return $this->belongsTo(Subscription::class);
    }
}
