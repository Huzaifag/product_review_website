<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
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
                'source' => 'name',
            ],
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        'title',
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
        return route('blog.category', $this->slug);
    }

    public function articles()
    {
        return $this->hasMany(BlogArticle::class, 'blog_category_id');
    }
}
