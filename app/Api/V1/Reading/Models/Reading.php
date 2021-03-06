<?php

namespace App\Api\V1\Reading\Models;

use App\Api\V1\Account\Models\User;
use App\Api\V1\Reflection\Models\Reflection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * List of fields that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'reading_date',
        'reading_day',

        'first_reading_title',
        'first_reading_book',
        'first_reading_body',

        'second_reading_title',
        'second_reading_book',
        'second_reading_body',

        'responsorial_title',
        'responsorial_book',
        'responsorial_body_one',
        'responsorial_body_two',
        'responsorial_body_one_verse',

        'gospel_title',
        'gospel_book',
        'gospel_body',
        'user_id'
    ];

    /**
     * Reading User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * Format the reading time day before it is persisted
     * @param $date
     */
    public function setReadingDateAttribute($date){

        $this->attributes['reading_date'] = Carbon::parse($date)->addHours(3);

    }

    /**
     * Format the reading time day before it is persisted
     * @param $date
     */
    public function setReadingDayAttribute($date){

        $this->attributes['reading_day'] = Carbon::parse($date)->addHours(3);

    }

    /**
     * Format the reading day after it is persisted
     * @param $date
     * @return string
     */
    public function getReadingDayAttribute($date){

        $dt = Carbon::parse($date);

       return $dt->timestamp.'000';

    }

    /**
     * A reading has a single reflection
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function reflection(){

        return $this->hasOne(Reflection::class);
    }

    public static function boot(){

        parent::boot();

        Reading::observe(new GlobalObserver());
    }

}
