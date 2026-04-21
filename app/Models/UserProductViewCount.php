<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProductViewCount extends Model
{
    protected $table = 'user_product_view_counts';

    protected $fillable = [
        'ip_address',
        'session_id',
        'season_id',
        'user_id',
        'plan_id',
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

    public function plan()
    {
        return $this->belongsTo(Plan::class);
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
}