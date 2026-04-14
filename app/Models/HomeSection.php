<?php

namespace App\Models;

use App\Models\Scopes\NestableScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HomeSection extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    protected static function booted()
    {
        static::addGlobalScope(new NestableScope);
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isPermanent()
    {
        return is_null($this->category_id) &&
        is_null($this->sub_category_id) && is_null($this->sub_sub_category_id);
    }

    public function isContentFromCategory()
    {
        return $this->category ? true : false;
    }

    public function isContentFromSubCategory()
    {
        return $this->subCategory ? true : false;
    }

    public function isContentFromSubSubCategory()
    {
        return $this->subSubCategory ? true : false;
    }

    protected $fillable = [
        'name',
        'description',
        'items_number',
        'cache_expiry_time',
        'category_id',
        'sub_category_id',
        'sub_sub_category_id',
        'status',
        'order',
    ];

    protected $with = [
        'category',
        'subCategory',
        'subSubCategory',
    ];

    protected function casts(): array
    {
        return [
            'items_number' => 'integer',
            'cache_expiry_time' => 'integer',
            'status' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
            'description' => $this->description ? m_trans($this->description) : null,
        ];
    }

    public function getCategory()
    {
        $category = null;
        if (!$this->isPermanent()) {
            if ($this->isContentFromCategory()) {
                $category = $this->category;
            } elseif ($this->isContentFromSubCategory()) {
                $category = $this->subCategory;
            } elseif ($this->isContentFromSubSubCategory()) {
                $category = $this->SubSubCategory;
            }
        }

        return $category;
    }

    public function getBusinesses()
    {
        if (!$this->isPermanent()) {
            $category = $this->getCategory();
            if (!$category || !$category->slug) {
                return collect();
            }

            $cacheMinutes = Carbon::now()->addMinutes($this->cache_expiry_time);
            $cacheKey = "home_businesses_" . Str::slug($category->slug, '_');

            return Cache::remember($cacheKey, $cacheMinutes, function () use ($category) {
                return $category->businesses()
                    ->inRandomOrder()
                    ->limit($this->items_number)
                    ->get();
            });
        }

        return null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function subSubCategory()
    {
        return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_id');
    }
}
