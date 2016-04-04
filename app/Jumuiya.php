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
        'happening_on'
    ];

}
