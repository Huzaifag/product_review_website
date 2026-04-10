<?php

namespace App\Jobs\Business;

use App\Classes\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNewBusinessReviewNotification implements ShouldQueue
{
    use Queueable;

    public $businessOwner;
    public $businessReview;

    public function __construct($businessOwner, $businessReview)
    {
        $this->businessOwner = $businessOwner;
        $this->businessReview = $businessReview;
    }

    public function handle()
    {
        $owner = $this->businessOwner;
        $businessReview = $this->businessReview;
        $business = $businessReview->business;

        SendMail::send($owner->email, 'business_new_review', [
            'name' => $owner->getName(),
            'business_name' => $business->trans->name,
            'reviewer_name' => $businessReview->reviewer->name,
            'review_link' => $businessReview->getLink(),
            'website_name' => m_trans(config('settings.general.site_name')),
        ]);
    }
}