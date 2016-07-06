<?php

namespace App\Api\V1\Station\Models;

use App\Api\V1\Parish\Models\Parish;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;


class Station extends Model
{
    /**
     * The table used by this model
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


    public function parish(){

        return $this->belongsTo(Parish::class);
    }

    public static function boot(){

        parent::boot();

        Station::observe(new GlobalObserver());
    }

    public function scopeSearch($query, $search){

        return $query->where(function($query) use ($search){

            $query->where('station_name', 'LIKE', "%$search%");

        });
    }

}
