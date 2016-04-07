<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prayer_types extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'prayer_types';

    /**
     * The fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'prayer_type_name',
        'prayer_type_description',
        'user_id'

    ];

}
