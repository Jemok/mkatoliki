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

        'reading_date',

        'first_reading_title',
        'first_reading_book',
        'first_reading_body',

        'second_reading_title',
        'second_reading_book',
        'first_reading_body',

        'responsorial_title',
        'responsorial_book',
        'responsorial_body_one',
        'responsorial_body_two',

        'gospel_title',
        'gospel_book',
        'gospel_body'

    ];

    /**
     * Reading User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * Format the reading time date before it is persisted
     * @param $date
     */
    public function setReadingAttribute($date){



        $this->attributes['reading_date'] = Carbon::parse($date);

    }

    /**
     * Format the reading date after it is persisted
     * @param $date
     * @return string
     */
    public function getReadingDateAttribute($date){

        $dt = Carbon::parse($date);

       return $dt->timestamp.'000';

    }

}
