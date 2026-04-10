<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessOwnerLoginLog extends Model
{
    protected $fillable = [
        'business_owner_id',
        'ip',
        'country',
        'country_code',
        'timezone',
        'location',
        'latitude',
        'longitude',
        'browser',
        'os',
    ];

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }
}
