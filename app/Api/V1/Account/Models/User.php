<?php

namespace App\Api\V1\Account\Models;

use App\Api\V1\Feedback\Models\Feedback;
use App\Api\V1\GCM\Models\GcmPushType;
use App\Api\V1\GCM\Models\Phone_token;
use App\Api\V1\Happening\Models\Happening_event;
use App\Api\V1\Jumuiya\Models\Jumuiya;
use App\Api\V1\Parish\Models\Parish;
use App\Api\V1\Prayer\Models\Prayer;
use App\Api\V1\Prayer_Type\Models\Prayer_types;
use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;
use App\Api\V1\Reflection\Models\Reflection;
use App\Api\V1\Station\Models\Station;
use App\Api\V1\Subscription\Models\Subscription;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
use App\Api\V1\Subscription\Models\SubscriptionStatusType;
use App\Api\V1\Subscription\Models\UserSubscription;
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

    public function subscriptions(){

        return $this->hasMany(Subscription::class);
    }

    public function subscription_categories(){

        return $this->hasMany(SubscriptionCategory::class);
    }


    public function subscription_status(){

        return $this->hasMany(SubscriptionStatus::class);
    }

    /**
     * User -- GcmPushType Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gcm_push_types(){

        return $this->hasMany(GcmPushType::class);
    }

    /**
     * Phone_token User relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function phone_token(){

        return $this->hasOne(Phone_token::class);
    }

    /**
     * User Feedback relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks(){

        return $this->hasMany(Feedback::class);

    }

    /**
     * User Roles relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles(){

        return $this->hasMany(Role::class);
    }

    /**
     * User UserRoles relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_role(){

        return $this->hasOne(User_roles::class);
    }

    public function isAdmin(){

        if($this->user_role()->first()->role_id == 0)
            return true;
        return false;
    }

    public function isParishAdmin(){

        if($this->user_role()->first()->role_id == 1)
            return true;
        return false;
    }

    public function isOutstationAdmin(){

        if($this->user_role()->first()->role_id == 2)
            return true;
        return false;
    }

    public function isPriest(){

        if($this->user_role()->first()->role_id == 3)
            return true;
        return false;
    }

    public function isAppUser(){

        if($this->user_role()->first()->role_id == 4)
            return true;
        return false;
    }
}