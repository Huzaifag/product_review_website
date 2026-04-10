<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

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
        'image',
        'title',
        'description',
        'keywords',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'views' => 'integer',
        ];
    }

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
            'title' => $this->title ? m_trans($this->title) : null,
            'description' => $this->description ? m_trans($this->description) : null,
            'keywords' => $this->keywords ? m_trans($this->keywords) : null,
        ];
    }

    public function getImageLink()
    {
        return asset($this->image);
    }

    public function getLink(array $attributes = [])
    {
        return route('categories.category', [$this->slug] + $attributes);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
