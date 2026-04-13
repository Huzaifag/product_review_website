<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLogs extends Model
{
    protected $fillable = [
        'query',
        'results_count',
        'ip_address',
        'user_agent',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'results_count' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
