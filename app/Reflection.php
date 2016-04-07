<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reflection extends Model
{
    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'reflection_body',
        'reflection_date',
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
}
