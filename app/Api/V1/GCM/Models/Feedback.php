<?php

namespace App;

use App\Api\V1\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * The table used by this model
     * @var string
     *
     *
     */
    protected $table = "feedbacks";

    /**
     * The fields that can be  mass assigned
     * @var array
     */
    protected $fillable = [

        'mood',
        'comment'

    ];

    /**
     * Feedback User relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }
}
