<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessReviewReply extends Model
{
    protected $fillable = [
        'body',
        'business_review_id',
        'business_owner_id',
        'business_id',
    ];

    public function getTransAttribute()
    {
        return (object) [
            'body' => m_trans($this->body),
        ];
    }

    public function review()
    {
        return $this->belongsTo(BusinessReview::class, 'business_review_id');
    }

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
