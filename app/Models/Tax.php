<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
        'name',
        'rate',
        'countries',
    ];

    protected function casts(): array
    {
        return [
            'rate' => 'integer',
            'countries' => 'array',
        ];
    }

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
        ];
    }
}
