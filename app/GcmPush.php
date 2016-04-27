<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GcmPush extends Model
{
    /**
     * The table associated with this model
     * @var string
     *
     */
    protected $table = 'gcm_pushes';

    /**
     * All the fields that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'message_id'
    ];
}
