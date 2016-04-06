<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

        'parish_name'

    ];

    /***
     * The Parish Station Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations(){
        return $this->hasMany(Station::class);
    }
}
