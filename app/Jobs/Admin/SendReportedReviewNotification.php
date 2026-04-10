<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendReportedReviewNotification implements ShouldQueue
{
    use Queueable;

    public $admin;
    public $businessReviewReport;

    public function __construct($admin, $businessReviewReport)
    {
        $this->admin = $admin;
        $this->businessReviewReport = $businessReviewReport;
    }

    public function handle()
    {
        $admin = $this->admin;
        $businessReviewReport = $this->businessReviewReport;

        SendMail::send($admin->email, 'admin_reported_review', [
            "name" => $businessReviewReport->user->getName(),
            "report_id" => $businessReviewReport->id,
            "view_link" => route('admin.reported-reviews.show', $businessReviewReport->id),
            "website_name" => m_trans(config('settings.general.site_name')),
        ]);
    }
}