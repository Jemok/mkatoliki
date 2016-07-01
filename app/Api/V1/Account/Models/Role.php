<?php

namespace App\Api\V1\Account\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table used by this model
     * @var string
     */
    protected $table = 'roles';

    /**
     * The fields that might be mass assigned
     * @var array
     */
    protected $fillable = [

        'description',
        'role_power',
        'user_id'

    ];

    /**
     * Role User relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * Role UserRole relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_roles(){

        return $this->hasMany(User_roles::class);
    }
}
