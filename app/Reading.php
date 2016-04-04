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

    /**
     * Reading User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * Format the mass time date before it is persisted
     * @param $date
     */
    public function setMassDayAttribute($date){



        $this->attributes['mass_day'] = Carbon::parse($date);

    }

    /**
     * Format the mass time date after it is persisted
     * @param $date
     * @return string
     */
    public function getMassDayAttribute($date){

        $dt = Carbon::parse($date);

       return $dt->timestamp.'000';

    }

}
