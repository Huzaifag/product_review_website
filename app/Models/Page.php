<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable;

    protected static function booted()
    {
        static::addGlobalScope(new LanguageScope);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected $fillable = [
        'title',
        'slug',
        'body',
        'description',
        'keywords',
        'views',
        'lang',
    ];

    protected function casts(): array
    {
        return [
            'views' => 'integer',
        ];
    }

    public function getLink()
    {
        return route('page', $this->slug);
    }
}
