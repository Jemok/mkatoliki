<?php

namespace App\Api\V1\Announcement\Models;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /**
     * Table used by this model
     * @var string
     */
    protected $table = 'announcements';

    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'title',
        'announcement',
        'date'
    ];

    /**
     * Announcement User relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }
}
