<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteUserRecord extends Model
{
    protected $table = 'invite_user_records';

    protected $fillable = [
        'id', 'user_id', 'department_id', 'email', 'token', 'expired','role_name'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
}
