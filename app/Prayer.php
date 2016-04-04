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
}
