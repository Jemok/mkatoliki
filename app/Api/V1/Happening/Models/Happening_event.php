<?php

namespace App\Api\V1\Happening\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

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
        'event_excerpt',
        'event_date'
    ];

    /**
     * Happening_event User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    public static function boot(){

        parent::boot();

        Happening_event::observe(new GlobalObserver());
    }
}
