<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTag extends Model
{

    public $incrementing = false;
    
    protected $table = 'company_tag';

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'company_id', 'tag_id'
    ];
}
