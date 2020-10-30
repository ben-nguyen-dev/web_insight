<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'id', 'name', 'company_id', 'default_department'
    ];

    public function employments()
    {
        return $this->hasMany('App\Models\Employment');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }
}
