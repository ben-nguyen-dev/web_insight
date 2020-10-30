<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'is_active', 'removed_date'
    ];

    public function companies()
    {
        return $this->belongsToMany('App\Models\Company', 'company_tag');
    }
}
