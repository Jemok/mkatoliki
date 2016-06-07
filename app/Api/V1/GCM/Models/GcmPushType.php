<?php

namespace App\Api\V1\GCM\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class GcmPushType extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'gcm_push_types';

    /**
     * The fields that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'type_name',
        'type_code'
    ];

    /**
     * GcmPushType -- GcmPush Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gcm_push(){

        return $this->hasMany(GcmPush::class);
    }

    /**
     * GcmPushType -- User Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }
}
