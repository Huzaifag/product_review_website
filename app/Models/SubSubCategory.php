<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
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
        'title',
        'description',
        'keywords',
        'views',
        'sub_category_id',
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

    public function getLink(array $attributes = [])
    {
        return route('categories.sub-sub-category',
            [$this->subCategory->category->slug, $this->subCategory->slug, $this->slug] + $attributes);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_sub_sub_category');
    }
}
