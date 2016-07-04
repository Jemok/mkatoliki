<?php

namespace App\Api\V1\Announcement\Models;

use App\Api\V1\Account\Models\User;
use App\Observers\GroupObserver;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

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
        'date',
        'station_id'
    ];

    /**
     * Announcement User relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * The boot methods
     */

    public static function boot(){

        parent::boot();

        Announcement::observe(new GroupObserver());
    }
}
