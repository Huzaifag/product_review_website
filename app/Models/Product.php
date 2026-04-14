<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Sluggable;
    use SoftDeletes;

    const UNVERIFIED = 0;
    const VERIFIED = 1;

    const NOT_TRENDING = 0;
    const TRENDING = 1;

    const NOT_BEST_RATING = 0;
    const BEST_RATING = 1;

    const NOT_FEATURED = 0;
    const FEATURED = 1;

    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

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

    public function images()
    {
        return $this->hasMany(ProductImage::class);
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
        if ($this->image) {
            return asset($this->image);
        }

        if ($this->relationLoaded('images') && $this->images->first()) {
            return asset($this->images->first()->path);
        }

        return asset(config('theme.settings.general.social_image'));
    }

    public function getIngredientsList(): array
    {
        if (!$this->ingredients_inci) {
            return [];
        }


        return array_values(array_filter(array_map('trim', explode(',', $this->ingredients_inci))));
    }

    public function getLink()
    {
        return route('products.show', $this->slug ?? $this->id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', self::STATUS_ACTIVE);
    }
}
