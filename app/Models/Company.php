<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
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


    protected $fillable = [
        'id', 'type', 'registration_number', 'email', 'phone_number', 'website', 'linked_in', 'is_verified', 'is_consultant'
    ];

    public function departments()
    {
        return $this->hasMany('App\Models\Department');
    }

    public function addressRecords()
    {
        return $this->hasMany('App\Models\AddressRecord');
    }

    public function SniRecords()
    {
        return $this->hasMany('App\Models\SniRecord');
    }

    public function CpvRecords()
    {
        return $this->hasMany('App\Models\CpvRecord');
    }

    public function nameRecords()
    {
        return $this->hasMany('App\Models\NameRecord');
    }

    public function domainRecords()
    {
        return $this->hasMany('App\Models\DomainRecord');
    }

    public function electronicInvoices()
    {
        return $this->hasMany('App\Models\ElectronicInvoice');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'company_tag');
    }

}
