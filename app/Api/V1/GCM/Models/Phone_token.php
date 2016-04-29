<?php

namespace App\Api\V1\GCM\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class Phone_token extends Model
{
    /**
     * Table used by this model
     * @var string
     */
    protected $table = 'phone_tokens';

    /**
     * Fields that may be mass assigned
     * @var array
     */
    protected $fillable = [

        'token'

    ];

    /**
     * User Phone_token relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function user(){

        return $this->belongsTo(User::class);
    }


}
