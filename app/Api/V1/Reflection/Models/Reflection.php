<?php

namespace App\Api\V1\Reflection\Models;

use App\Api\V1\Account\Models\User;
use App\Api\V1\Reading\Models\Reading;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Observers\GlobalObserver;

class Reflection extends Model
{
    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'reflection_body',
        'reflection_date',
        'reflection_day',
        'reading_id',
        'user_id'
    ];

    /**
     * Reflection User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * A reflection belongs to a single reading
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reading(){

        return $this->belongsTo(Reading::class);
    }

    /**
     * Format the reflection time date before it is persisted
     * @param $date
     */
    public function setReflectionDateAttribute($date){

        $this->attributes['reflection_date'] = Carbon::parse($date)->addHours(3);

    }

    /**
     * Format the reflection time day before it is persisted
     * @param $date
     */
    public function setReflectionDayAttribute($date){

        $this->attributes['reflection_day'] = Carbon::parse($date)->addHours(3);

    }

    /**
     * Format the reflection day after it is persisted
     * @param $date
     * @return string
     */
    public function getReflectionDayAttribute($date){

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

        Reflection::observe(new GlobalObserver());
    }
}
