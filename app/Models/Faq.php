<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use App\Models\Scopes\NestableScope;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new LanguageScope);
        static::addGlobalScope(new NestableScope);
    }

    protected $fillable = [
        'title',
        'body',
        'order',
        'lang',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }
}
