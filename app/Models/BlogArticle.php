<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class BlogArticle extends Model
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
        'image',
        'body',
        'description',
        'keywords',
        'views',
        'blog_category_id',
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
        return route('blog.article', $this->slug);
    }

    public function getImageLink()
    {
        return asset($this->image);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
