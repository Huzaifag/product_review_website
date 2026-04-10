<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class BusinessReviewReported
{
    use SerializesModels;

    public $businessReviewReport;

    public function __construct($businessReviewReport)
    {
        $this->businessReviewReport = $businessReviewReport;
    }

}