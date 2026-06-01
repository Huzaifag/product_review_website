<?php

namespace App\Http\Controllers\Admin;

use App\Events\BusinessReviewPublished;
use App\Http\Controllers\Controller;
use App\Jobs\User\SendBusinessReviewRejectedNotification;
use App\Models\BusinessReview;
use App\Models\BusinessReviewReport;
use App\Models\PaymentGateway;
use App\Models\UserReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        
        $query = UserReview::whereHas('product')
            ->with(['user', 'product'])
            ->latest();

        // Search (by review text, user name, product name)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Optional: filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Optional: filter by status        
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'rejected') {
                $query->where('is_approved', false);
            }
        }

        $reviews = $query->paginate(20)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(UserReview $review)
    {
        abort_if(!$review->product, 404);

        return view('admin.reviews.show', compact('review'));
    }

    // Approve a review
    public function approve(UserReview $review)
    {
        $review->is_approved = true;
        $review->save();
        toastr()->success(d_trans('Review approved successfully'));
        return redirect()->route('admin.reviews.show', $review->id);
    }

    // Reject a review
    public function reject(UserReview $review)
    {
        $review->is_approved = false;
        $review->save();
        toastr()->success(d_trans('Review rejected successfully'));
        return redirect()->route('admin.reviews.show', $review->id);
    }

    public function pendingReviews()
    {
        $reviews = BusinessReview::pending();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $reviews->search($searchTerm, $searchTermStart);
        }

        if (request()->filled('user')) {
            $reviews->where('user_id', request('user'));
        }

        $reviews = $reviews->with(['user', 'reply'])
            ->orderbyDesc('id')->paginate(20);
        $reviews->appends(request()->only(['search', 'user']));

        return view('admin.pending-reviews.index', [
            'reviews' => $reviews,
        ]);
    }

    public function pendingReviewsShow(BusinessReview $businessReview)
    {
        return view('admin.pending-reviews.show', [
            'review' => $businessReview,
        ]);
    }

    public function pendingReviewsPublish(BusinessReview $businessReview)
    {
        $businessReview->status = BusinessReview::STATUS_PUBLISHED;
        $businessReview->update();

        event(new BusinessReviewPublished($businessReview));

        toastr()->success(d_trans('Published Successfully'));
        return redirect()->route('admin.pending-reviews.index');
    }

    public function pendingReviewsReject(BusinessReview $businessReview)
    {
        dispatch(new SendBusinessReviewRejectedNotification($businessReview));

        $businessReview->delete();

        toastr()->success(d_trans('Rejected Successfully'));
        return redirect()->route('admin.pending-reviews.index');
    }

    public function pendingReviewsDestroy(BusinessReview $businessReview)
    {
        $businessReview->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    public function reportedReviews()
    {
        $reportedReviews = BusinessReviewReport::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $reportedReviews->where(function ($query) use ($searchTerm, $searchTermStart) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('reason', 'like', $searchTerm)
                    ->OrWhereHas('review', function ($query) use ($searchTerm, $searchTermStart) {
                        $query->search($searchTerm, $searchTermStart);
                    });
            });
        }

        if (request()->filled('user')) {
            $reportedReviews->where('user_id', request('user'));
        }

        $reportedReviews = $reportedReviews->with(['review', 'user', 'business'])
            ->orderbyDesc('id')->paginate(50);
        $reportedReviews->appends(request()->only(['search', 'user']));

        return view('admin.reported-reviews.index', [
            'reportedReviews' => $reportedReviews,
        ]);
    }

    public function reportedReviewsShow(BusinessReviewReport $reportedReview)
    {
        return view('admin.reported-reviews.show', [
            'reportedReview' => $reportedReview,
        ]);
    }

    public function reportedReviewsReviewDelete(BusinessReviewReport $reportedReview)
    {
        $reportedReview->review->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return redirect()->route('admin.reported-reviews.index');
    }

    public function reportedReviewsDestroy(BusinessReviewReport $reportedReview)
    {
        $reportedReview->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return redirect()->route('admin.reported-reviews.index');
    }
}
