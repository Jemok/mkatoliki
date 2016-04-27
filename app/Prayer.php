<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;


class Prayer extends Model
{
    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'prayer_title',
        'prayer_body',
        'prayer_type_id',
        'user_id'
    ];

    /**
     * Prayer User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    public static function boot(){

        parent::boot();

        Prayer::observe(new GlobalObserver());
    }
}
