<?php

namespace App\Http\Controllers;

use App\Classes\ReCaptcha;
use App\Events\BusinessReviewCreated;
use App\Events\BusinessReviewReported;
use App\Events\BusinessReviewUpdated;
use App\Models\Business;
use App\Models\BusinessReview;
use App\Models\BusinessReviewReport;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = self::getResultByParams();

        $searchCategories = Category::inRandomOrder()
            ->limit(10)->get();

        $popularSearches = Category::orderByDesc('views')
            ->limit(10)->get()->shuffle();

        return theme_view('businesses.index', [
            'businesses' => $businesses,
            'searchCategories' => $searchCategories,
            'popularSearches' => $popularSearches,
        ]);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_website' => ['required', 'url', 'block_patterns', 'max:255', 'unique:businesses,website'],
        ] + app(ReCaptcha::class)->validate());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $website = cleanURL($request->business_website);
        $domain = cleanDomain($website);

        $businessExists = Business::where('website', $website)
            ->orWhere('domain', $domain)->exists();
        if ($businessExists) {
            toastr()->error(d_trans('The business website has already been taken'));
            return back();
        }

        $websiteName = config('settings.general.site_name');
        $shortDescription = "Rate and review {$request->business_name} on {$websiteName}";

        $business = new Business();
        $business->name = $domain;
        $business->website = $website;
        $business->domain = $domain;
        $business->short_description = $shortDescription;
        $business->save();

        $title = d_trans('New Business Added (:business_name)', ['business_name' => $business->trans->name]);
        $image = $business->getLogoLink();
        $link = route('admin.businesses.show', $business->id);
        adminNotify($title, $image, $link);

        toastr()->success(d_trans('The business has been added successfully you can now leave a review'));
        return redirect($business->getLink());
    }

    public function claim(Request $request, $id)
    {
        $business = Business::active()->unclaimed()
            ->where('id', hash_decode($id))->firstOrFail();

        if (authBusinessOwner()) {
            return redirect()->route('business.claim.index', $id);
        }

        $request->session()->put('claimed_business', $id);
        return redirect()->route('business.register');
    }

    public function embed($id)
    {
        $business = Business::active()->verified()
            ->where('id', hash_decode($id))->firstOrFail();

        return theme_view('businesses.embed', [
            'business' => $business,
        ]);
    }

    public function ajaxSearch(Request $request)
    {
        $searchTerm = '%' . $request->search . '%';
        $searchTermStart = $request->search . '%';

        $businesses = Business::active()
            ->search($searchTerm, $searchTermStart)
            ->select('name', 'domain', 'logo', 'is_verified', 'avg_ratings')
            ->orderByRaw("CASE WHEN name LIKE ? THEN 0 ELSE 1 END", [$searchTermStart])
            ->orderByDesc('id')
            ->get();

        $results = [];
        foreach ($businesses as $business) {
            $results[] = [
                'name' => $business->trans->name,
                'domain' => $business->domain,
                'logo' => $business->getLogoLink(),
                'is_verified' => $business->isVerified(),
                'rating_avg' => $business->avg_ratings,
                'rating_stars' => $business->getAvgRatingImageLink(),
                'link' => $business->getLink(),
            ];
        }

        return response()->json($results);
    }

    public function show($domain)
    {
        $business = Business::where('domain', $domain)
            ->active()->firstOrFail();

        $reviews = $business->reviews()
            ->published()->with(['user', 'reply']);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $reviews->search($searchTerm, $searchTermStart);
        }

        if (request()->filled('stars')) {
            $reviews->whereIn('stars', request('stars'));
        }

        if (request()->filled('country')) {
            $reviews->whereHas('user', function ($query) {
                $query->where('country', request('country'));
            });
        }

        if (request()->filled('review_time')) {
            $dateFilter = request('review_time');
            switch ($dateFilter) {
                case 'this_month':
                    $reviews->whereBetween('created_at', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth(),
                    ]);
                    break;
                case 'last_month':
                    $reviews->whereBetween('created_at', [
                        Carbon::now()->subMonth()->startOfMonth(),
                        Carbon::now()->subMonth()->endOfMonth(),
                    ]);
                    break;
                case 'this_year':
                    $reviews->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'last_year':
                    $reviews->whereYear('created_at', Carbon::now()->subYear()->year);
                    break;
                default:
                    break;
            }
        }

        $user = authUser();
        if ($user) {
            $reviews->orderByRaw('CASE WHEN user_id = ? THEN 0 ELSE 1 END, id DESC', [$user->id]);
        } else {
            $reviews->orderByRaw('CASE WHEN ip_address = ? THEN 0 ELSE 1 END, id DESC', [getIp()]);
        }

        $reviews = $reviews->paginate(10);
        $reviews->appends(request()->only(['search', 'review_time', 'country', 'stars']));

        $reviewStats = $business->getReviewStarStats();

        $similarBusinesses = $business->category ? $business->category->businesses()->active() : Business::active();
        $similarBusinesses = $similarBusinesses->whereNot('id', $business->id)->inRandomOrder()->limit(10)->get();

        return theme_view('businesses.show', [
            'business' => $business,
            'starPercentages' => $reviewStats['percentages'],
            'reviews' => $reviews,
            'similarBusinesses' => $similarBusinesses,
        ]);
    }

    public function reviewCreate($domain)
    {
        $business = Business::where('domain', $domain)
            ->active()->firstOrFail();

        return theme_view('businesses.review.create', [
            'business' => $business,
        ]);
    }

    public function reviewStore(Request $request, $domain)
    {
        $user = authUser();

        if (config('settings.business.actions.reviews_require_login') && !$user) {
            toastr()->info(d_trans('Please sing in to your account in order to leave a review'));
            return redirect()->route('login');
        }

        $business = Business::where('domain', $domain)
            ->active()->firstOrFail();

        $rules = [
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'description' => ['required', 'string', 'block_patterns', 'min:60', 'max:4000'],
            'title' => ['required', 'string', 'block_patterns', 'max:100'],
            'experience_date' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:' . Carbon::now()->subYears(2)->toDateString()],
        ];

        if (!config('settings.business.actions.reviews_require_login') && !$user) {
            $rules['name'] = ['required', 'string', 'block_patterns', 'max:255'];
            $rules['email'] = ['required', 'email', 'indisposable', 'block_patterns', 'max:255'];
        } else {
            $request->name = null;
            $request->email = null;
        }

        $validator = Validator::make($request->all(), $rules + app(ReCaptcha::class)->validate());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $ipAddress = getIp();

        $businessReviewed = BusinessReview::where('business_id', $business->id)
            ->where(function ($query) use ($user, $ipAddress) {
                if ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('ip_address', $ipAddress);
                } else {
                    $query->whereNull('user_id')
                        ->where('ip_address', $ipAddress);
                }
            })
            ->exists();

        if ($businessReviewed) {
            toastr()->error(d_trans('You have a review for this business already'));
            return back()->withInput();
        }

        $review = new BusinessReview();
        $review->title = $request->title;
        $review->body = $request->description;
        $review->experience_date = $request->experience_date;
        $review->stars = $request->stars;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->status = config('settings.business.actions.reviews_require_reviewing') ? BusinessReview::STATUS_PENDING : BusinessReview::STATUS_PUBLISHED;
        $review->ip_address = $ipAddress;
        $review->user_id = $user ? $user->id : null;
        $review->business_id = $business->id;
        $review->save();

        $redirect = $review->isPublished() ? $review->getLink() : $business->getLink();

        event(new BusinessReviewCreated($review));

        if ($review->isPending()) {
            toastr()->warning(d_trans('Your review submitted and under review. Thank you for sharing your experience'));
        } else {
            toastr()->success(d_trans('Your review has been successfully published. Thank you for sharing your experience'));
        }

        return redirect($redirect);
    }

    public function reviewShow($domain, $id)
    {
        $business = Business::where('domain', $domain)
            ->active()->firstOrFail();

        $review = $business->reviews()
            ->published()->where('id', $id)->firstOrFail();

        return theme_view('businesses.review.show', [
            'business' => $business,
            'review' => $review,
        ]);
    }

    public function reviewUpdate(Request $request, $domain, $id)
    {
        $business = Business::where('domain', $domain)
            ->active()->firstOrFail();

        $review = $business->reviews()->forCurrentUser()
            ->published()->where('id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string', 'block_patterns', 'min:60', 'max:4000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($review->body != $request->description) {
            $updated = true;
            $status = config('settings.business.actions.reviews_require_reviewing') ? BusinessReview::STATUS_PENDING : BusinessReview::STATUS_PUBLISHED;
        } else {
            $updated = false;
            $status = $review->status;
        }

        $review->body = $request->description;
        $review->status = $status;
        $review->update();

        if ($updated) {
            if ($review->hasReply()) {
                $review->reply->delete();
            }

            if (($review->hasReply() && $status == BusinessReview::STATUS_PUBLISHED) || $status == BusinessReview::STATUS_PENDING) {
                event(new BusinessReviewUpdated($review));
            }
        }

        if ($review->isPending()) {
            toastr()->warning(d_trans('Your review updated and under review'));
        } else {
            toastr()->success(d_trans('Your review has been updated successfully'));
        }

        if ($review->isPending()) {
            return redirect($business->getLink());
        }

        return back();
    }

    public function reviewReport(Request $request, $domain, $id)
    {
        $business = Business::where('domain', $domain)
            ->active()->firstOrFail();

        $review = $business->reviews()->published()
            ->where('id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'report_reason' => ['required', 'string', 'block_patterns', 'max:1000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $user = authUser();
        $reviewUser = $review->user;

        if ($reviewUser && $reviewUser->id == $user->id || $review->ip_address == getIp()) {
            toastr()->error(d_trans('You cannot report your own reviews'));
            return back();
        }

        $reportExists = BusinessReviewReport::where('business_review_id', $review->id)
            ->where('user_id', $user->id)->exists();

        if ($reportExists) {
            toastr()->error(d_trans('You have reported this review already'));
            return back();
        }

        $report = new BusinessReviewReport();
        $report->reason = $request->report_reason;
        $report->business_review_id = $review->id;
        $report->user_id = $user->id;
        $report->business_id = $business->id;
        $report->save();

        event(new BusinessReviewReported($report));

        toastr()->success(d_trans('Your report has been received, we will review it and take a necessary action'));
        return back();
    }

    public function reviewDelete(Request $request, $domain, $id)
    {
        $business = Business::where('domain', $domain)
            ->active()->firstOrFail();

        $review = $business->reviews()->forCurrentUser()
            ->published()->where('id', $id)->firstOrFail();

        $review->delete();

        toastr()->success(d_trans('Your review has been deleted successfully'));
        return $request->filled('_referrer') ? redirect($request->_referrer) : back();
    }

    public static function getResultByParams($category = null, $subCategory = null, $subSubCategory = null)
    {
        $businesses = Business::active();

        if ($category) {
            $businesses = $businesses->where('category_id', $category->id);
        }

        if ($subCategory) {
            $businesses->whereHas('subSubCategories', function ($query) use ($subCategory) {
                $query->where('sub_category_id', $subCategory->id);
            });
        }

        if ($subSubCategory) {
            $businesses->whereHas('subSubCategories', function ($query) use ($subSubCategory) {
                $query->where('sub_sub_categories.id', $subSubCategory->id);
            });
        }

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $businesses->search($searchTerm, $searchTermStart);
        }

        if (request()->filled('country')) {
            $businesses->where('country', request('country'));
        }

        if (request()->filled('city_zip')) {
            $businesses->where(function ($query) {
                $query->where('city', request('city_zip'))
                    ->orWhere('zip', request('city_zip'));
            });
        }

        if (request()->filled('stars')) {
            $businesses->where('avg_ratings', '>=', request('stars'));
        }

        if (request()->filled('verified')) {
            $verified = request('verified') ? Business::VERIFIED : Business::UNVERIFIED;
            $businesses->where('is_verified', $verified);
        }

        if (request()->filled('trending')) {
            $businesses->trending();
        }

        if (request()->filled('best_rating')) {
            $businesses->bestRating();
        }

        if (request()->filled('featured')) {
            $businesses->featured();
        }

        if (request()->filled('review_time')) {
            $dateFilter = request('review_time');
            switch ($dateFilter) {
                case 'this_month':
                    $businesses->whereHas('reviews', function ($query) {
                        $query->published()->whereBetween('created_at', [
                            Carbon::now()->startOfMonth(),
                            Carbon::now()->endOfMonth(),
                        ]);
                    });
                    break;
                case 'last_month':
                    $businesses->whereHas('reviews', function ($query) {
                        $query->published()->whereBetween('created_at', [
                            Carbon::now()->subMonth()->startOfMonth(),
                            Carbon::now()->subMonth()->endOfMonth(),
                        ]);
                    });
                    break;
                case 'this_year':
                    $businesses->whereHas('reviews', function ($query) {
                        $query->published()->whereYear('created_at', Carbon::now()->year);
                    });
                    break;
                case 'last_year':
                    $businesses->whereHas('reviews', function ($query) {
                        $query->published()->whereYear('created_at', Carbon::now()->subYear()->year);
                    });
                    break;
                default:
                    break;
            }
        }

        if (request()->filled('best_rating')) {
            $businesses->orderbyDesc('businesses.avg_ratings');
        } else {
            if (isset($searchTermStart)) {
                $businesses->orderByRaw("CASE WHEN name LIKE ? THEN 1 ELSE 2 END", [$searchTermStart])->orderByDesc('businesses.current_month_views');
            } else {
                $businesses->orderByDesc('businesses.current_month_views');
            }
        }

        $businesses = $businesses->with('category')->paginate(30);

        $businesses->appends(request()->only(['search', 'review_time', 'country', 'city_zip', 'stars', 'verified']));

        $businesses->getCollection()->transform(function ($business) {
            $business->cached_reviews = Cache::remember(
                "business:{$business->id}:reviews",
                now()->addDay(),
                fn() => $business->reviews()->published()
                    ->with(['user', 'business'])->orderbyDesc('id')->limit(6)->get()
            );

            return $business;
        });

        $businesses->getCollection()->transform(function ($business) {
            return Cache::remember("business:{$business->id}:first_categories", now()->addDay(), function () use ($business) {
                $linkedSubSubs = $business->subSubCategories;
                $grouped = $linkedSubSubs->groupBy('sub_category_id')->filter();
                $firstGroup = $grouped->first();

                if (!$firstGroup || !$firstGroup->first()?->subCategory) {
                    $business->first_categories = null;
                    return $business;
                }

                $subCategory = $firstGroup->first()->subCategory;

                $business->first_categories = (object) [
                    'subCategory' => $subCategory,
                    'subSubCategories' => $firstGroup,
                ];

                return $business;
            });
        });

        return $businesses;
    }

}
