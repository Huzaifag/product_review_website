<?php

namespace App\Listeners;

use App\Events\BusinessReviewPublished;
use App\Jobs\Business\SendNewBusinessReviewNotification;
use App\Jobs\User\SendBusinessReviewPublishedNotification;

class ProcessBusinessReviewPublished
{
    public function handle(BusinessReviewPublished $event)
    {
        $review = $event->businessReview;
        $business = $review->business;

        dispatch(new SendBusinessReviewPublishedNotification($review));

        if ($business->hasOwner()) {
            dispatch(new SendNewBusinessReviewNotification($business->owner, $review));
        }

        foreach ($business->employees as $employee) {
            if ($employee->isActive()) {
                dispatch(new SendNewBusinessReviewNotification($employee, $review));
            }
        }

        $title = d_trans('New Review From (:name)', ['name' => $review->reviewer->name]);
        $image = asset('images/notifications/business-review.png');
        $link = route('business.reviews.index');
        businessNotify($business->id, $title, $image, $link);
    }
}
