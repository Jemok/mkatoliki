<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_parishes extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'user_parishes';

    /**
     * The fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'user_id',
        'parish_id'

    ];


}
