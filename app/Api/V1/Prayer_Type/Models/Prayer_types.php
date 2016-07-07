<?php

namespace App\Api\V1\Prayer_Type\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\SoftDeletes;


class Prayer_types extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'prayer_types';

    /**
     * The fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'prayer_type_name',
        'prayer_type_description',
        'user_id'

    ];

    public static function boot(){

        parent::boot();

        Prayer_types::observe(new GlobalObserver());
    }

}
