<?php

namespace App\Api\V1\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_stations extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
