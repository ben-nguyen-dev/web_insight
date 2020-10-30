<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePage extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'user_id', 'profile_title', 'profile_description', 'location', 'status', 'added_date', 'removed_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
}
