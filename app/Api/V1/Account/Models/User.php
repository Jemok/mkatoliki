<?php

namespace App\Api\V1\Account\Models;

use App\Api\V1\GCM\Models\Phone_token;
use App\Api\V1\Happening\Models\Happening_event;
use App\Api\V1\Jumuiya\Models\Jumuiya;
use App\Api\V1\Parish\Models\Parish;
use App\Api\V1\Prayer\Models\Prayer;
use App\Api\V1\Prayer_Type\Models\Prayer_types;
use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;
use App\Api\V1\Reflection\Models\Reflection;
use App\Api\V1\Station\Models\Station;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Api\V1\Reading\Models\Reading;
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'parish_id',
        'station_id',
        'phone_notification_token'

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * This mutator automatically hashes the password.
     *
     * @var string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    //This models relationships below

    /**
     * The one to many User to Reading relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readings(){
        return $this->hasMany(Reading::class);
    }

    /**
     * The one to many User to Prayer relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function prayers(){
        return $this->hasMany(Prayer::class);
    }

    /**
     * The User Jumauiya one to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jumuiyas(){

        return $this->hasMany(Jumuiya::class);
    }

    /**
     * The User Reflection one to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reflections(){

        return $this->hasMany(Reflection::class);
    }

    /**
     * The user Happening_event one to many relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function happenings(){

        return $this->hasMany(Happening_event::class);
    }

    /**
     * Raw Jumuiya User relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function raw_jumuiya(){

        return $this->hasMany(Raw_jumuiya::class);
    }

    /**
     * The User Parish relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parishes(){

        return $this->hasMany(Parish::class);
    }


    /**
     * The use stations relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations(){

        return $this->hasMany(Station::class);
    }

    public function user_parishes(){

        return $this->hasMany(User_parishes::class);
    }

    public function user_stations(){

        return $this->hasMany(User_stations::class);
    }

    public function prayer_types(){

        return $this->hasMany(Prayer_types::class);
    }

    /**
     * Phone_token User relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function phone_token(){

        return $this->hasOne(Phone_token::class);
    }
}