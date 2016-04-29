<?php

namespace App\Api\V1\Raw_Jumuiya\Models;

use App\Api\V1\Account\Models\User;
use App\Api\V1\Jumuiya\Models\Jumuiya;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

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
        'jumuiya_image_link',
        'user_id'
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

    public static function boot(){
        parent::boot();

        Raw_jumuiya::observe(new GlobalObserver());
    }

}
