<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raw_jumuiya extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'raw_jumuiyas';

    /**
     * All the fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'jumuiya_name',
        'jumuiya_image_link'

    ];

    /**
     * Jumuiya Jumuiya Event relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jumuiya_event(){

        return $this->hasMany(Jumuiya::class);
    }

    /**
     * Raw Jumuiya User Reltionship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(){

        return $this->belongsTo(User::class);
    }

}
