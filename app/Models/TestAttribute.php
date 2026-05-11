<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAttribute extends Model
{
    protected $fillable = [
        'name',
        'type',
        'options',
        'status',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    //type() with multiple types for search
    public function scopeType($query, $types)
    {
        return $query->whereIn('type', $types);
    }
}
