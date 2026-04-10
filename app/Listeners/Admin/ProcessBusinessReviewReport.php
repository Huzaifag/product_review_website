<?php

namespace App\Listeners\Admin;

use App\Events\BusinessReviewReported;
use App\Jobs\Admin\SendReportedReviewNotification;
use App\Models\Admin;

class ProcessBusinessReviewReport
{
    public function handle(BusinessReviewReported $event)
    {
        $businessReviewReport = $event->businessReviewReport;

        $admins = Admin::all();
        foreach ($admins as $admin) {
            dispatch(new SendReportedReviewNotification($admin, $businessReviewReport));
        }

        $title = d_trans('New Reported Review [#:report_id]', ['report_id' => $businessReviewReport->id]);
        $image = asset('images/notifications/report.png');
        $link = route('admin.reported-reviews.show', $businessReviewReport->id);
        adminNotify($title, $image, $link);
    }
}