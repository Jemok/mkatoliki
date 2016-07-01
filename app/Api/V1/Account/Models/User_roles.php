<?php

namespace App\Api\V1\Account\Models;


use Illuminate\Database\Eloquent\Model;

class User_roles extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = "user_roles";

    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $fillable = [

        'role_id'
    ];

    /**
     * UserRole user relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * UserRole role relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(){

        return $this->belongsTo(Role::class);
    }
}
