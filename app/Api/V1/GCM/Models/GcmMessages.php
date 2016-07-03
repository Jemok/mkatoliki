<?php

namespace App\Api\V1\GCM\Models;

use App\Api\V1\GCM\Models\GcmPush;
use Illuminate\Database\Eloquent\Model;

class GcmMessages extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = "gcm_messages";

    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [
      'message_id'
    ];

    /**
     * GcmMessage GcmPush relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gcm_push(){

        return $this->belongsTo(GcmPush::class);
    }
}
