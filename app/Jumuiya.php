<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

}
