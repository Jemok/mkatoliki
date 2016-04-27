<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;


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
        'parish_id',
        'user_id'

    ];

    public static function boot(){

        parent::boot();

        Station::observe(new GlobalObserver());
    }
}
