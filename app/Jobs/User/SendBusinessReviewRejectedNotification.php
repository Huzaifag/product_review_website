<?php

namespace App\Jobs\User;

use App\Classes\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendBusinessReviewRejectedNotification implements ShouldQueue
{
    use Queueable;

    public $businessReview;

    public function __construct($businessReview)
    {
        $this->businessReview = $businessReview;
    }

    public function handle()
    {
        $businessReview = $this->businessReview;
        $reviewer = $businessReview->reviewer;
        $business = $businessReview->business;

        SendMail::send($reviewer->email, 'user_review_rejected', [
            'name' => $reviewer->name,
            'business_name' => $business->trans->name,
            'business_link' => $business->getLink(),
            'website_name' => m_trans(config('settings.general.site_name')),
        ]);
    }
}