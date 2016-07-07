<?php

namespace App\Api\V1\Prayer\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\SoftDeletes;


class Prayer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
