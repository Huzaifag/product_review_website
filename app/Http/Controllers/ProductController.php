<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\UserProductViewCount;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = self::getResultByParams();

        $searchCategories = Category::inRandomOrder()
            ->limit(10)->get();

        $popularSearches = Category::orderByDesc('views')
            ->limit(10)->get()->shuffle();

        return theme_view('products.index', [
            'products' => $products,
            'searchCategories' => $searchCategories,
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
            $products->where('sub_category_id', $subCategory->id);
        }

        if ($subSubCategory) {
            $products->where('sub_category_id', $subSubCategory->sub_category_id);
        }

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $products->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('brand_name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('ingredients_inci', 'like', $searchTerm);
            });
        }

        if (request()->filled('featured')) {
            $products->where('is_featured', Product::FEATURED);
        }

        if (request()->filled('review_time')) {
            $dateFilter = request('review_time');
            switch ($dateFilter) {
                case 'this_month':
                    $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereBetween('created_at', [
                            Carbon::now()->startOfMonth(),
                            Carbon::now()->endOfMonth(),
                        ]);
                    });
                    break;
                case 'last_month':
                    $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereBetween('created_at', [
                            Carbon::now()->subMonth()->startOfMonth(),
                            Carbon::now()->subMonth()->endOfMonth(),
                        ]);
                    });
                    break;
                case 'this_year':
                    $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereYear('created_at', Carbon::now()->year);
                    });
                    break;
                case 'last_year':
                    $products->whereHas('userReviews', function ($query) {
                        $query->approved()->whereYear('created_at', Carbon::now()->subYear()->year);
                    });
                    break;
                default:
                    break;
            }
        }

        if (request()->filled('best_rating')) {
            $products->withCount([
                'userReviews as approved_reviews_count' => function ($query) {
                    $query->approved();
                }
            ])->orderByDesc('approved_reviews_count')->orderByDesc('products.view_count');
        } else {
            if (isset($searchTermStart)) {
                $products->orderByRaw("CASE WHEN name LIKE ? THEN 1 ELSE 2 END", [$searchTermStart])->orderByDesc('products.view_count');
            } else {
                $products->orderByDesc('products.view_count');
            }
        }

        $products = $products->with(['category', 'subCategory.subSubCategories'])->paginate(30);

        $products->appends(request()->only(['search', 'review_time', 'featured', 'best_rating']));

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
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->with(['brand', 'category', 'subCategory', 'labTestingResult', 'ingredientConcerns', 'images'])
            ->withCount([
                'userReviews as approved_reviews_count' => function ($query) {
                    $query->approved();
                },
            ])
            ->firstOrFail();

        $product->increment('view_count');

        $similarProducts = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('sub_category_id', $product->sub_category_id)
            ->with('labTestingResult')
            ->limit(3)
            ->get();


        $userProductViewCount = $this->retrieveOrCreateUserProductViewCount($product->id);

        $plan = $userProductViewCount->plan;


        $canSeeDetails = $this->canSeeProductDetails($plan->products_limit, $userProductViewCount, $product->id);


        return theme_view('products.show', [
            'product' => $product,
            'similarProducts' => $similarProducts,
            'canSeeDetails' => $canSeeDetails,
        ]);
    }

    //retrieve or save UserProductViewCount for current user or guest and increment viewed product count

    private function retrieveOrCreateUserProductViewCount($productId)
    {
        // Trust Cloudflare header first, then fall back to request IP.
        $ip = request()->header('CF-Connecting-IP') ?: request()->ip();
        
        $userId = auth()->check() ? auth()->id() : null;

        $subscription = null;
        if ($userId) {
            $subscription = Subscription::active()
                ->where('user_id', $userId)
                ->whereHas('plan', function ($query) {
                    $query->whereNot('interval', Plan::INTERVAL_LIFETIME);
                })
                ->first();
        }

        $defaultPlan = Plan::where('interval', Plan::INTERVAL_LIFETIME)->first();

        // Retrieve or create the UserProductViewCount record
        $userProductViewCount = UserProductViewCount::firstOrCreate(
            [
                'ip_address' => $ip,
                'user_id' => $userId,
                'plan_id' => $subscription ? $subscription->plan_id : $defaultPlan?->id,
                'subscription_id' => $subscription ? $subscription->id : null,
            ]
        );

        $productsLimit = $subscription?->plan?->products_limit ?? $defaultPlan?->products_limit;

        // Only increment if this product hasn't been viewed yet and the limit allows it.
        $productIds = $userProductViewCount->product_ids ?? [];

        // Ensure it's an array (important if coming from JSON/DB)
        $productIds = is_array($productIds) ? $productIds : [];
        $alreadyViewed = in_array($productId, $productIds);
        $canAddNewView = is_null($productsLimit) || $alreadyViewed || count($productIds) < (int) $productsLimit;

        if (!$alreadyViewed && $canAddNewView) {
            $productIds[] = $productId;

            $userProductViewCount->product_ids = $productIds;
            $userProductViewCount->products_viewed = count($productIds);
            $userProductViewCount->save();
        }

        return $userProductViewCount;
    }

    private function canSeeProductDetails($products_limit, $userProductViewCount, $productId)
    {
        if (is_null($products_limit)) {
            return true; // Unlimited products
        }

        $productIds = $userProductViewCount->product_ids ?? [];
        $productIds = is_array($productIds) ? $productIds : [];

        // Always allow details for products already counted as viewed.
        if (in_array($productId, $productIds)) {
            return true;
        }

        return count($productIds) < (int) $products_limit;
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
            ->orderByRaw("CASE WHEN name LIKE ? THEN 0 ELSE 1 END", [$searchStart])
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
}
