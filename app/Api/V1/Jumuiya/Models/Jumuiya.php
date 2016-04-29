<?php

namespace App\Api\V1\Jumuiya\Models;

use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;


class Jumuiya extends Model
{
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
        'user_id'
    ];

    /**
     * Jumuiya User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * Jumuiya Jumuiya Event relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jumuiya(){

       return $this->belongsTo(Raw_jumuiya::class);
   }

   public static function boot(){

        parent::boot();

        Jumuiya::observe(new GlobalObserver());
    }

}
