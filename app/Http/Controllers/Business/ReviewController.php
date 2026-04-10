<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Jobs\User\SendBusinessReviewRepliedNotification;
use App\Models\BusinessReview;
use App\Models\BusinessReviewReply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = BusinessReview::where('business_id', currentBusiness()->id)
            ->published();

        if (request()->filled('status')) {
            if (request('status') == "replied") {
                $reviews->whereHas('reply');
            } elseif (request('status') == "not_replied") {
                $reviews->whereDoesntHave('reply');
            }
        }

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $reviews->search($searchTerm, $searchTermStart);
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'))->startOfDay();
            $reviews->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();
            $reviews->where('created_at', '<=', $dateTo);
        }

        if (request()->filled('stars')) {
            $reviews->where('stars', request('stars'));
        }

        if (request()->filled('sort')) {
            if (request('sort') === 'recent') {
                $reviews->orderBy('created_at', 'desc');
            } elseif (request('sort') === 'oldest') {
                $reviews->orderBy('created_at', 'asc');
            } else {
                $reviews->orderbyDesc('id');
            }
        } else {
            $reviews->orderbyDesc('id');
        }

        $reviews = $reviews->paginate(20);
        $reviews->appends(request()->only(['search', 'status', 'date_from', 'date_to', 'stars', 'sort']));

        return theme_view('business.reviews', [
            'reviews' => $reviews,
        ]);
    }

    public function reply(Request $request, $id)
    {
        $authBusinessOwner = authBusinessOwner();

        $review = BusinessReview::where('id', $id)
            ->where('business_id', currentBusiness()->id)
            ->whereDoesntHave('reply')
            ->published()->firstOrFail();

        $business = $authBusinessOwner->businesses()
            ->where('businesses.id', $review->business->id)
            ->active()->firstOrFail();

        $validator = Validator::make($request->all(), [
            'reply' => ['required', 'string', 'block_patterns', 'max:4000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $reply = new BusinessReviewReply();
        $reply->body = $request->reply;
        $reply->business_review_id = $review->id;
        $reply->business_owner_id = $authBusinessOwner->id;
        $reply->business_id = $business->id;
        $reply->save();

        dispatch(new SendBusinessReviewRepliedNotification($review));

        toastr()->success(d_trans('Your reply has been published successfully'));
        return back();
    }

    public function replyUpdate(Request $request, $id)
    {
        $authBusinessOwner = authBusinessOwner();

        $review = BusinessReview::where('id', $id)
            ->where('business_id', currentBusiness()->id)
            ->where(function ($query) use ($authBusinessOwner) {
                $query->whereHas('reply', function ($query) use ($authBusinessOwner) {
                    if (!$authBusinessOwner->isAdminOfCurrentBusiness()) {
                        $query->where('business_owner_id', $authBusinessOwner->id);
                    }
                });
            })
            ->published()
            ->firstOrFail();

        $authBusinessOwner->businesses()
            ->where('businesses.id', $review->business->id)
            ->active()->firstOrFail();

        $validator = Validator::make($request->all(), [
            'reply' => ['required', 'string', 'block_patterns', 'max:4000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $reply = $review->reply;
        $reply->body = $request->reply;
        $reply->update();

        toastr()->success(d_trans('The reply has been updated successfully'));
        return back();
    }
}