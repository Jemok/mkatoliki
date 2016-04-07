<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_stations extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'user_outstations';

    /**
     * The fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'user_id',
        'station_id'

    ];
}
