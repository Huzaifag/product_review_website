<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessView extends Model
{
    protected $fillable = [
        'ip',
        'referrer',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}