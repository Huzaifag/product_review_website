<?php

namespace App\Models;

use App\Models\Scopes\SortableScope;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    const NOT_FEATURED = 0;
    const FEATURED = 1;

    const INTERVAL_WEEK = 'week';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_YEAR = 'year';
    const INTERVAL_LIFETIME = 'lifetime';

    const NO_EMPLOYEES_FEATURE = 0;
    const EMPLOYEES_FEATURE = 1;

    const NO_CATEGORIES_FEATURE = 0;
    const CATEGORIES_FEATURE = 1;

    protected static function booted()
    {
        static::addGlobalScope(new SortableScope);
    }

    public function scopeWeekly($query)
    {
        $query->where('interval', self::INTERVAL_WEEK);
    }

    public function isWeekly()
    {
        return $this->interval == self::INTERVAL_WEEK;
    }

    public function scopeMonthly($query)
    {
        $query->where('interval', self::INTERVAL_MONTH);
    }

    public function isMonthly()
    {
        return $this->interval == self::INTERVAL_MONTH;
    }

    public function scopeYearly($query)
    {
        $query->where('interval', self::INTERVAL_YEAR);
    }

    public function isYearly()
    {
        return $this->interval == self::INTERVAL_YEAR;
    }

    public function scopeLifetime($query)
    {
        $query->where('interval', self::INTERVAL_LIFETIME);
    }

    public function isLifetime()
    {
        return $this->interval == self::INTERVAL_LIFETIME;
    }

    public function scopeDisabled($query)
    {
        $query->where('status', self::STATUS_DISABLED);
    }

    public function isDisabled()
    {
        return $this->status == self::STATUS_DISABLED;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isFeatured()
    {
        return $this->is_featured == self::FEATURED;
    }

    public function hasEmployeesFeature()
    {
        return $this->employees == self::EMPLOYEES_FEATURE;
    }

    public function hasCategoriesFeature()
    {
        return $this->categories == self::CATEGORIES_FEATURE;
    }

    protected $fillable = [
        'name',
        'interval',
        'price',
        'businesses',
        'categories',
        'employees',
        'custom_features',
        'is_featured',
        'status',
        'sort_id',
    ];

    protected function casts(): array
    {
        return [
            'custom_features' => 'object',
            'is_featured' => 'boolean',
            'status' => 'boolean',
            'sort_id' => 'integer',
        ];
    }

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
        ];
    }

    public function getIntervalDays()
    {
        if ($this->isWeekly()) {
            return 7;
        } else if ($this->isMonthly()) {
            return 30;
        } else if ($this->isYearly()) {
            return 365;
        }

        return null;
    }

    public function getIntervalName()
    {
        return self::getAvailableIntervals()[$this->interval];
    }

    public static function getAvailableIntervals()
    {
        return [
            self::INTERVAL_WEEK => d_trans('Weekly'),
            self::INTERVAL_MONTH => d_trans('Monthly'),
            self::INTERVAL_YEAR => d_trans('Yearly'),
            self::INTERVAL_LIFETIME => d_trans('Lifetime'),
        ];
    }

    public function getFormatPrice()
    {
        $price = $this->price;
        if (is_numeric($price) && floor($price) == $price) {
            return getAmount($price, 0, '.', '');
        } else {
            return getAmount($price, 2, '.', '');
        }
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
