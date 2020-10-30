<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{

    protected $fillable = [
        'id', 'department_id', 'user_id', 'job_title', 'job_description', 'work_email', 'work_phone', 'department_name', 'current_employment', 'start_date','end_date','public_procurement_experience','phone_number','linked_in'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function deparment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
}
