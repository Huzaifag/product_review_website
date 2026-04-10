<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendPendingReviewNotification implements ShouldQueue
{
    use Queueable;

    public $admin;
    public $businessReview;

    public function __construct($admin, $businessReview)
    {
        $this->admin = $admin;
        $this->businessReview = $businessReview;
    }

    public function handle()
    {
        $admin = $this->admin;
        $businessReview = $this->businessReview;

        SendMail::send($admin->email, 'admin_pending_review', [
            "name" => $businessReview->reviewer->name,
            "review_id" => $businessReview->id,
            "view_link" => route('admin.pending-reviews.show', $businessReview->id),
            "website_name" => m_trans(config('settings.general.site_name')),
        ]);
    }
}