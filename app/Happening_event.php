<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Happening_event extends Model
{
    /**
     * The table associated with this model
     * @var string
     */
    protected $table = 'happening_events';

    /**
     * All the fields that might be mass assigned
     * @var array
     */

    /**
     * All the mass assignable fields
     * @var array
     */
    protected $fillable = [
        'event_title',
        'event_body',
        'event_excerpt'
    ];

    /**
     * Happening_event User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }
}
