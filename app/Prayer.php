<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prayer extends Model
{
    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'title',
        'body'
    ];

    /**
     * Prayer User One to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }
}
