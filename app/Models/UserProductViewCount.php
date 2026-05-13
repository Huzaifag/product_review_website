<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProductViewCount extends Model
{
    protected $table = 'user_product_view_counts';

    protected $fillable = [
        'ip_address',
        'session_id',
        'user_id',
        'subscription_id',
        'products_viewed',
        'product_ids',
    ];

    protected $casts = [
        'product_ids' => 'array',
    ];

    // Relationships (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plans()
    {
        return Plan::whereIn('id', $this->plan_ids ?? []);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    function incrementProductViews($productId)
    {
        $this->products_viewed += 1;

        // Add product ID to the list if not already present
        $productIds = $this->product_ids ?? [];
        if (!in_array($productId, $productIds)) {
            $productIds[] = $productId;
            $this->product_ids = $productIds;
        }
        $this->save();
    }

    //get all viewed product ids
    public function getViewedProductIds()
    {
        return $this->product_ids ?? [];
    }

    public function viewedProducts()
    {
        return $this->hasMany(Product::class, 'id', 'product_ids');
    }
}