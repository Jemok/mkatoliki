<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    /**
     * List of fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'first_reading',
        'second_reading',
        'responsorial',
        'gospel',
        'mass_day'

    ];

    public function setMassDayAttribute($date){



        $this->attributes['mass_day'] = Carbon::parse($date);

    }

    public function getMassDayAttribute($date){

        $dt = Carbon::parse($date);

       return $dt->timestamp.'000';

    }

}
