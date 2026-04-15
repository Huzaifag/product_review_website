<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
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
        'category_id',
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
        return route('categories.sub-category', [$this->category->slug, $this->slug] + $attributes);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class, 'sub_category_id');
    }

    public function businesses()
    {
        return Business::whereHas('subSubCategories', function ($query) {
            $query->where('sub_sub_categories.sub_category_id', $this->id);
        });
    }


   

}
