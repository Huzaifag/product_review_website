<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'slug',
        'brand_name',
        'image',
        'description',
        'price',
        'currency',
        'product_size',
        'organic_certified',
        'organic_certifier',
        'overall_grade',
        'ingredients_inci',
        'lab_verified',
        'test_date',
        'test_year',
        'test_edition',
        'magazine_page',
        'is_featured',
        'is_active',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'organic_certified' => 'boolean',
            'lab_verified' => 'boolean',
            'test_date' => 'date',
            'magazine_page' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'view_count' => 'integer',
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function labTestingResult()
    {
        return $this->hasOne(LabTestingResult::class);
    }

    public function ingredientConcerns()
    {
        return $this->hasMany(IngredientConcern::class);
    }

    public function userReviews()
    {
        return $this->hasMany(UserReview::class);
    }

    public function savedProducts()
    {
        return $this->hasMany(SavedProduct::class);
    }

    public function getImageLink()
    {
        return $this->image ? asset($this->image) : asset(config('theme.settings.general.social_image'));
    }

    public function getIngredientsList(): array
    {
        if (!$this->ingredients_inci) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->ingredients_inci))));
    }
}
