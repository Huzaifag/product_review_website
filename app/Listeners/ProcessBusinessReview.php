<?php

namespace App\Listeners;

use App\Events\BusinessReviewCreated;
use App\Events\BusinessReviewPublished;
use App\Events\BusinessReviewUpdated;
use App\Jobs\Admin\SendPendingReviewNotification;
use App\Models\Admin;

class ProcessBusinessReview
{
    public function handle(BusinessReviewCreated | BusinessReviewUpdated $event)
    {
        $review = $event->businessReview;

        if ($review->isPublished()) {
            event(new BusinessReviewPublished($review));
        } elseif ($review->isPending()) {
            if (!isAddonActive('ai_reviewer') || !config('settings.ai_reviewer.status')) {
                $admins = Admin::all();
                foreach ($admins as $admin) {
                    dispatch(new SendPendingReviewNotification($admin, $review));
                }

                $title = d_trans('New Pending Review [#:review_id]', ['review_id' => $review->id]);
                $image = asset('images/notifications/review-pending.png');
                $link = route('admin.pending-reviews.show', $review->id);
                adminNotify($title, $image, $link);
            }
        }
    }
}