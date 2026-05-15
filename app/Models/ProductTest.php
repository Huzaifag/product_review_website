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

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
            'data' => $this->data ? collect($this->data)->map(fn($value) => m_trans($value))->all() : null,
        ];
    }

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
