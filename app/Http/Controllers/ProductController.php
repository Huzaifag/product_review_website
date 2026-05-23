<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\UserProductViewCount;
use App\Models\UserReview;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = self::getResultByParams();

        $searchCategories = Category::inRandomOrder()
            ->limit(10)->get();
        $searchBrands = Brand::inRandomOrder()
            ->limit(10)->get();

        $popularSearches = Category::orderByDesc('views')
            ->limit(10)->get()->shuffle();

        return theme_view('products.index', [
            'products' => $products,
            'searchCategories' => $searchCategories,
            'searchBrands' => $searchBrands,
            'popularSearches' => $popularSearches,
        ]);
    }

    public static function getResultByParams($category = null, $subCategory = null, $subSubCategory = null)
    {
        $products = Product::active();

        if ($category) {
            $products = $products->where('category_id', $category->id);
        }

        if ($subCategory) {
            $products = $products->where('sub_category_id', $subCategory->id);
        }

        if ($subSubCategory) {
            $products = $products->where('sub_category_id', $subSubCategory->sub_category_id);
        }

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $products = $products->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('ingredients_inci', 'like', $searchTerm)
                    ->orWhereHas('brand', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('brand', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    });

            });
        }

        if (request()->filled('category')) {
            $products = $products->whereHas('category', function ($query) {
                $query->where('slug', request('category'));
            });
        }

        if (request()->filled('brand')) {
            $products = $products->whereHas('brand', function ($query) {
                $query->where('slug', request('brand'));
            });
        }

        if (request()->filled('min_price')) {
            $products = $products->where('price', '>=', request('min_price'));
        }

        if (request()->filled('max_price')) {
            $products = $products->where('price', '<=', request('max_price'));
        }

        if (request()->filled('organic_certified')) {
            $products = $products->where('organic_certified', request('organic_certified'));
        }

        if (request()->filled('product_size')) {
            $products = $products->where('product_size', 'like', '%' . request('product_size') . '%');
        }

        if (request()->filled('featured')) {
            $products = $products->where('is_featured', Product::FEATURED);
        }

        if (request()->filled('review_time')) {
            $dateFilter = request('review_time');
            switch ($dateFilter) {
                case 'this_month':
                    $products = $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereBetween('created_at', [
                            Carbon::now()->startOfMonth(),
                            Carbon::now()->endOfMonth(),
                        ]);
                    });
                    break;
                case 'last_month':
                    $products = $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereBetween('created_at', [
                            Carbon::now()->subMonth()->startOfMonth(),
                            Carbon::now()->subMonth()->endOfMonth(),
                        ]);
                    });
                    break;
                case 'this_year':
                    $products = $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereYear('created_at', Carbon::now()->year);
                    });
                    break;
                case 'last_year':
                    $products = $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereYear('created_at', Carbon::now()->subYear()->year);
                    });
                    break;
                default:
                    break;
            }
        }

        if (request()->filled('best_rating')) {
            $products = $products->withCount([
                'userReviews as approved_reviews_count' => function ($query) {
                    $query->approved();
                },
            ])->orderByDesc('approved_reviews_count')->orderByDesc('products.view_count');
        } else {
            if (isset($searchTermStart)) {
                $products = $products->orderByRaw(
                    'CASE WHEN name LIKE ? THEN 1 ELSE 2 END',
                    [$searchTermStart]
                )->orderByDesc('products.view_count');
            } else {
                $products = $products->orderByDesc('products.view_count');
            }
        }

        $products = $products->with(['category', 'subCategory.subSubCategories'])->paginate(30);

        $products->appends(request()->only([
            'search',
            'category',
            'brand',
            'min_price',
            'max_price',
            'organic_certified',
            'product_size',
            'review_time',
            'featured',
            'best_rating',
        ]));

        $products->getCollection()->transform(function ($product) {
            $product->cached_reviews = Cache::remember(
                "product:{$product->id}:reviews",
                now()->addDay(),
                fn() => $product->userReviews()->approved()
                    ->with(['user', 'product'])->orderbyDesc('id')->limit(6)->get()
            );

            return $product;
        });

        $products->getCollection()->transform(function ($product) {
            return Cache::remember("product:{$product->id}:first_categories", now()->addDay(), function () use ($product) {
                $subCategory = $product->subCategory;

                if (!$subCategory) {
                    $product->first_categories = null;

                    return $product;
                }

                $product->first_categories = (object) [
                    'subCategory' => $subCategory,
                    'subSubCategories' => $subCategory->subSubCategories,
                ];

                return $product;
            });
        });

        return $products;
    }

    public function show($slug)
    {
        $product = Product::active()
            ->where(fn($q) => $q->where('slug', $slug)->orWhere('id', $slug))
            ->with(['brand', 'category', 'subCategory', 'ingredientConcerns', 'images', 'productTest', 'ingredientLibraries'])
            ->withCount([
                'userReviews as approved_reviews_count' => fn($q) => $q->approved(),
            ])
            ->firstOrFail();
        Product::where('id', $product->id)->update([
            'view_count' => DB::raw('view_count + 1')
        ]);

        if (auth()->check()) {
            $canSeeDetails = $this->recordProductViewsAcrossSubscriptions(auth()->id(), [$product->id]);
            $productViewCount = null;
        } else {
            $canSeeDetails = $this->canSeeProductDetails($product->id);
            $productViewCount = $canSeeDetails
                ? $this->incrementProductViewCount($product->id)
                : null;
        }
        
        $similarProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('sub_category_id', $product->sub_category_id)
            ->limit(3)
            ->get();

        $testAttributes = collect();

        if ($product->productTest?->data) {
            $testAttributes = \App\Models\TestAttribute::whereIn('id', array_keys($product->productTest->data))
                ->where('status', 'active')
                ->get();
        }

        return theme_view('products.show', compact(
            'product',
            'similarProducts',
            'canSeeDetails',
            'testAttributes',
            'productViewCount'
        ));
    }

    private function resolveUsageSubscriptionForProducts(?int $userId, array $productIds): ?Subscription
    {
        $productIds = collect($productIds)
            ->filter()
            ->unique()
            ->values();

        if (!$userId || $productIds->isEmpty()) {
            return null;
        }

        $subscriptions = Subscription::with('plan')
            ->where('user_id', $userId)
            ->active()
            ->orderBy('started_at')
            ->get();

        foreach ($subscriptions as $subscription) {
            $plan = $subscription->plan;
            if (!$plan) {
                continue;
            }

            if (is_null($plan->products_limit)) {
                return $subscription;
            }

            $userProductViewCount = UserProductViewCount::where('user_id', $userId)
                ->where('subscription_id', $subscription->id)
                ->first();

            $existingIds = collect($userProductViewCount?->product_ids ?? [])
                ->filter()
                ->unique();

            $newIds = $productIds->diff($existingIds);
            if ($newIds->isEmpty()) {
                return $subscription;
            }
            $remaining = (int) $plan->products_limit - $existingIds->count();

            if ($newIds->count() <= $remaining) {
                return $subscription;
            }
        }

        return null;
    }

    private function recordProductViewsAcrossSubscriptions(int $userId, array $productIds): bool
    {
        $productIds = collect($productIds)
            ->filter()
            ->unique()
            ->values();

        if ($productIds->isEmpty()) {
            return true;
        }

        $subscriptions = Subscription::with('plan')
            ->where('user_id', $userId)
            ->active()
            ->orderBy('started_at')
            ->get();

        if ($subscriptions->isEmpty()) {
            return false;
        }

        $subscriptionIds = $subscriptions->pluck('id');
        $counts = UserProductViewCount::where('user_id', $userId)
            ->whereIn('subscription_id', $subscriptionIds)
            ->get()
            ->keyBy('subscription_id');

        $existingAll = $counts
            ->flatMap(fn($count) => $count->product_ids ?? [])
            ->filter()
            ->unique();

        $newIds = $productIds->diff($existingAll)->values();
        if ($newIds->isEmpty()) {
            return true;
        }

        $totalRemaining = 0;
        $hasUnlimited = false;
        foreach ($subscriptions as $subscription) {
            $plan = $subscription->plan;
            if (!$plan) {
                continue;
            }
            if (is_null($plan->products_limit)) {
                $hasUnlimited = true;
                break;
            }
            $existingIds = collect($counts->get($subscription->id)?->product_ids ?? [])
                ->filter()
                ->unique();
            $remaining = (int) $plan->products_limit - $existingIds->count();
            if ($remaining > 0) {
                $totalRemaining += $remaining;
            }
        }

        if (!$hasUnlimited && $totalRemaining < $newIds->count()) {
            return false;
        }

        $ip = request()->header('CF-Connecting-IP') ?: request()->ip();
        $sessionId = session()->getId();

        foreach ($subscriptions as $subscription) {
            $plan = $subscription->plan;
            if (!$plan) {
                continue;
            }

            if ($newIds->isEmpty()) {
                break;
            }

            $existingIds = collect($counts->get($subscription->id)?->product_ids ?? [])
                ->filter()
                ->unique();

            if (is_null($plan->products_limit)) {
                $assigned = $newIds->all();
                $newIds = collect();
            } else {
                $remaining = (int) $plan->products_limit - $existingIds->count();
                if ($remaining <= 0) {
                    continue;
                }
                $assigned = $newIds->take($remaining)->values()->all();
                $newIds = $newIds->slice(count($assigned))->values();
            }

            if (empty($assigned)) {
                continue;
            }

            $userProductViewCount = UserProductViewCount::firstOrCreate(
                [
                    'user_id' => $userId,
                    'subscription_id' => $subscription->id,
                ],
                [
                    'ip_address' => $ip,
                    'session_id' => $sessionId,
                    'product_ids' => [],
                    'products_viewed' => 0,
                ]
            );

            $updatedIds = $existingIds->merge($assigned)->unique()->values()->all();
            $userProductViewCount->update([
                'ip_address' => $ip,
                'session_id' => $sessionId,
                'product_ids' => $updatedIds,
                'products_viewed' => count($updatedIds),
            ]);
        }

        return true;
    }

    function incrementProductViewCount($productIds)
    {
        $productIds = collect(is_array($productIds) ? $productIds : [$productIds])
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($productIds)) {
            return null;
        }

        $ip = request()->header('CF-Connecting-IP') ?: request()->ip();
        $sessionId = session()->getId();

        $subscription = auth()->check()
            ? $this->resolveUsageSubscriptionForProducts(auth()->id(), $productIds)
            : null;

        if (auth()->check() && !$subscription) {
            return null;
        }

        if (auth()->check()) {
            $where = [
                'user_id' => auth()->id(),
                'subscription_id' => $subscription?->id,
            ];
        } else {
            $where = [
                'session_id' => $sessionId,
                'user_id' => null,
            ];
        }

        $userProductViewCount = UserProductViewCount::firstOrCreate(
            $where,
            [
                'ip_address' => $ip,
                'session_id' => $sessionId,
                'subscription_id' => $subscription?->id,
                'product_ids' => [],
                'products_viewed' => 0,
            ]
        );

        $existingIds = $userProductViewCount->product_ids ?? [];

        $newIds = collect($productIds)
            ->diff($existingIds)
            ->values()
            ->toArray();

        if (empty($newIds)) {
            return $userProductViewCount;
        }

        $updatedIds = collect($existingIds)
            ->merge($newIds)
            ->unique()
            ->values()
            ->toArray();

        $userProductViewCount->update([
            'ip_address' => $ip,
            'session_id' => $sessionId,
            'subscription_id' => $subscription?->id,
            'product_ids' => $updatedIds,
            'products_viewed' => count($updatedIds),
        ]);

        return $userProductViewCount;
    }

    function canSeeProductDetails($productIds): bool
{
    $productIds = collect(is_array($productIds) ? $productIds : [$productIds])
        ->filter()
        ->unique()
        ->values();

    if ($productIds->isEmpty()) {
        return false;
    }

    $sessionId = session()->getId();

        $subscription = auth()->check()
            ? $this->resolveUsageSubscriptionForProducts(auth()->id(), $productIds->toArray())
            : null;

        $hasActiveSubscriptions = auth()->check()
            ? Subscription::where('user_id', auth()->id())->active()->exists()
            : false;

        if ($hasActiveSubscriptions && !$subscription) {
            return false;
        }

        $plan = $subscription?->plan;

    // Guest OR logged-in user without subscription uses Free plan
    if (!$plan) {
        $plan = Plan::where('name', 'Free')
            ->active()
            ->first();
    }

    if (!$plan) {
        return false;
    }

    if (auth()->check()) {
        $where = [
            'user_id' => auth()->id(),
            'subscription_id' => $subscription?->id,
        ];
    } else {
        $where = [
            'session_id' => $sessionId,
            'user_id' => null,
        ];
    }

    $userProductViewCount = UserProductViewCount::where($where)->first();

    $existingIds = collect($userProductViewCount?->product_ids ?? [])
        ->filter()
        ->unique()
        ->values();

    // Only count products that are not already viewed
    $newIds = $productIds
        ->diff($existingIds)
        ->values();

    // Already viewed products are always allowed
    if ($newIds->isEmpty()) {
        return true;
    }

    // Null means unlimited
    if (is_null($plan->products_limit)) {
        return true;
    }

    $currentViewed = $existingIds->count();

    return ($currentViewed + $newIds->count()) <= (int) $plan->products_limit;
}

    //Product Comparion
    public function comparison($id)
    {
        $product = Product::active()->findOrFail($id);

        $similarProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('sub_category_id', $product->sub_category_id)
            ->where('product_size', $product->product_size)
            ->with('labTestingResult')
            ->inRandomOrder()
            ->limit(2)
            ->get();

        $similarIds = $similarProducts->pluck('id')->toArray();

        $allProductIds = collect([$product->id])
            ->merge($similarIds)
            ->unique()
            ->values()
            ->toArray();

        if (auth()->check()) {
            $canSeeDetails = $this->recordProductViewsAcrossSubscriptions(auth()->id(), $allProductIds);
            $userProductViewCount = null;
        } else {
            $canSeeDetails = $this->canSeeProductDetails($allProductIds);
            $userProductViewCount = $canSeeDetails
                ? $this->incrementProductViewCount($allProductIds)
                : null;
        }

        $productTests = \App\Models\ProductTest::whereIn('product_id', $allProductIds)
            ->get()
            ->keyBy('product_id');

        $mainTest = $productTests->get($product->id);

        $allTestIds = collect();

        foreach ($productTests as $test) {
            if ($test->data) {
                $allTestIds = $allTestIds->merge(array_keys($test->data));
            }
        }

        $allTestIds = $allTestIds->unique()->sort();

        $testAttributes = \App\Models\TestAttribute::whereIn('id', $allTestIds->values())
            ->where('status', 'active')
            ->get();

        $testName = $mainTest?->name ?? $productTests->first()?->name ?? null;

        $overallGradeAttr = $testAttributes->first(
            fn($a) => in_array(strtolower($a->name), ['overall_grade', 'gesamturteil'])
        );

        $overallGradeAttrId = $overallGradeAttr?->id;

        $overallGrades = collect();

        foreach ($allProductIds as $pid) {
            $test = $productTests->get($pid);

            $overallGrades->put(
                $pid,
                ($overallGradeAttrId && $test && isset($test->data[$overallGradeAttrId]))
                ? $test->data[$overallGradeAttrId]
                : null
            );
        }

        return theme_view('products.comparison', compact(
            'product',
            'similarProducts',
            'productTests',
            'mainTest',
            'testAttributes',
            'testName',
            'overallGrades',
            'canSeeDetails',
            'userProductViewCount'
        ));
    }



    public function reviewStore(Request $request, $slug)
    {

        $user = authUser();
        if (!$user) {
            toastr()->info(d_trans('Please sign in to your account in order to leave a review'));

            return redirect()->route('login');
        }

        $product = Product::active()
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'block_patterns', 'max:255'],
            'body' => ['required', 'string', 'block_patterns', 'min:20', 'max:2000'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }

            return back()->withInput();
        }

        $alreadyReviewed = UserReview::where('product_id', $product->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyReviewed) {
            toastr()->error(d_trans('You already submitted a review for this product'));

            return back()->withInput();
        }

        $review = new UserReview;
        $review->product_id = $product->id;
        $review->user_id = $user->id;
        $review->title = $request->title;
        $review->rating = $request->rating;
        $review->body = $request->body;
        $review->is_approved = false;
        $review->is_flagged = false;
        $review->helpful_count = 0;
        $review->save();
        self::adminReviewNotify($user, $review, $product);

        toastr()->success(d_trans('Your review has been submitted successfully wait for admin approval'));

        return back();
    }

    public function reviewHelpful($review)
    {
        $user = authUser();
        if (!$user) {
            toastr()->info(d_trans('Please sign in to your account in order to mark a review as helpful'));

            return redirect()->route('login');
        }

        $review = UserReview::approved()->where('id', $review)->firstOrFail();

        $cacheKey = 'user_review_helpful:' . $user->id . ':' . $review->id;
        if (Cache::has($cacheKey)) {
            toastr()->info(d_trans('You already marked this review as helpful'));

            return back();
        }

        $review->helpful_count = ($review->helpful_count ?? 0) + 1;
        $review->is_helpful = true;
        $review->save();

        Cache::put($cacheKey, true, now()->addDays(30));

        toastr()->success(d_trans('Thanks for your feedback'));

        return back();
    }






    public function ajaxSearch(Request $request)
    {
        $searchTerm = trim((string) $request->search);

        if ($searchTerm === '') {
            return response()->json([]);
        }

        $searchLike = '%' . $searchTerm . '%';
        $searchStart = $searchTerm . '%';

        $products = Product::active()
            ->with(['category', 'brand'])
            ->where(function ($query) use ($searchLike) {
                $query->where('name', 'like', $searchLike)
                    ->orWhere('description', 'like', $searchLike)
                    ->orWhere('ingredients_inci', 'like', $searchLike);
            })
            ->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', [$searchStart])
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        return response()->json($products->map(function (Product $product) {
            return [
                'name' => $product->name,
                'brand' => $product->brand?->name ?: ($product->brand_name ?: d_trans('Unknown brand')),
                'image' => $product->getImageLink(),
                'category' => $product->category?->trans->name ?? d_trans('Uncategorized'),
                'grade' => $product->overall_grade ? str_replace('_', ' ', ucfirst($product->overall_grade)) : null,
                'lab_verified' => $product->lab_verified,
                'link' => $product->getLink(),
            ];
        }));
    }

    public function ingredients(Request $request, $slug)
    {
        $product = Product::active()
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->with(['ingredientConcerns', 'labTestingResult'])
            ->firstOrFail();

        return theme_view('products.ingredients', [
            'product' => $product,
        ]);
    }

    public static function adminReviewNotify($user, $review, $product)
    {
        $title = d_trans(':username added a review for :product', [
            'username' => $user->getName(),
            'product' => $product->name,
        ]);
        $image = $user->getAvatar();
        $link = route('admin.reviews.show', $review->id);

        return adminNotify($title, $image, $link);
    }
}
