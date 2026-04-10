<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class BusinessReviewUpdated
{
    use SerializesModels;

    public $businessReview;

    public function __construct($businessReview)
    {
        return $this->businessReview = $businessReview;
    }
}