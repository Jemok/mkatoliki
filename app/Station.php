<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    /**
     * THe table used by this model
     * @var string
     */
    protected $table = 'stations';


    /**
     * All the fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'station_name',
        'parish_id'

    ];
}
