<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
