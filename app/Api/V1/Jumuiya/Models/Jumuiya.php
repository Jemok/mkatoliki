<?php

namespace App\Api\V1\Jumuiya\Models;

use App\Api\V1\Account\Models\User;
use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Jumuiya extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'location',
        'happening_on',
        'raw_jumuiya_id',
        'mass',
        'more_details',
        'user_id',
        'day_event_name'
    ];

    /**
     * Jumuiya -- User One to many Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * Jumuiya -- JumuiyaEvent Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jumuiya(){

       return $this->belongsTo(Raw_jumuiya::class);
   }

    /**
     * Format the happening on date before it is persisted
     * @param $date
     */
    public function setHappeningOnAttribute($date){

        $this->attributes['happening_on'] = Carbon::parse($date)->addHours(3);
    }

    /**
     * The boot methods
     */

    public static function boot(){

        parent::boot();

        Jumuiya::observe(new GlobalObserver());
    }

}
