<?php

namespace App\Api\V1\Parish\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;


class Parish extends Model
{
    /**
     * The table used by this migration
     * @var string
     */
    protected $table = 'parishes';

    /**
     * ALl the fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'parish_name',
        'user_id'

    ];

    /***
     * The Parish Station Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations(){
        return $this->hasMany(Station::class);
    }

    public static function boot(){

        parent::boot();

        Parish::observe(new GlobalObserver());
    }
}
