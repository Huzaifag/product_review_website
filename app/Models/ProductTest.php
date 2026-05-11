<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTest extends Model
{
    protected $fillable = [
        'name',
        'product_id',
        'category_id',
        'sub_category_id',
        'data',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    // ── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
