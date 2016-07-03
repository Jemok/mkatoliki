<?php

namespace App\Api\V1\GCM\Models;

use Illuminate\Database\Eloquent\Model;

class GcmPush extends Model
{
    /**
     * The table associated with this model
     * @var string
     *
     */
    protected $table = 'gcm_pushes';

    /**
     * All the fields that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'message_id',
        'multicast_id',
        'success',
        'failure',
        'conical_ids',
        'gcm_push_type_id'
    ];

    /**
     * GcmPush -- GcmPushType Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gcm_push_type(){

        return $this->belongsTo(GcmPushType::class);
    }

    /**
     * GcmPush GcmMessage relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gcm_messages(){

        return $this->hasMany(GcmMessages::class);
    }
}
