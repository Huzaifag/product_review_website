<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessReviewReport extends Model
{
    protected $fillable = [
        'reason',
        'business_review_id',
        'user_id',
        'business_id',
    ];

    public function review()
    {
        return $this->belongsTo(BusinessReview::class, 'business_review_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
