<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_name', 'password', 'avatar', 'first_name', 'last_name','full_name','user_token','user_active','expires', 'is_verified','code_verify'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','user_role');
    }

    public function employments()
    {
        return $this->hasMany('App\Models\Employment');
    }

    public function profilePages()
    {
        return $this->hasMany('App\Models\ProfilePage');
    }
    
    public function isAdministrator($role_name) {
        return $this->roles()->where('name', $role_name)->exists();
    }
}
