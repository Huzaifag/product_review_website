<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BusinessController;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $search = request('search');

        $categories = Category::with(['subCategories' => function ($query) {
            $query->with('subSubCategories');
        }])->withCount(['businesses' => function ($query) {
            $query->active();
        }])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('keywords', 'like', "%{$search}%")
                        ->orWhereHas('subCategories', function ($subQ) use ($search) {
                            $subQ->where('name', 'like', "%{$search}%")
                                ->orWhere('slug', 'like', "%{$search}%")
                                ->orWhere('title', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%")
                                ->orWhere('keywords', 'like', "%{$search}%")
                                ->orWhereHas('subSubCategories', function ($subSubQ) use ($search) {
                                    $subSubQ->where('name', 'like', "%{$search}%")
                                        ->orWhere('slug', 'like', "%{$search}%")
                                        ->orWhere('title', 'like', "%{$search}%")
                                        ->orWhere('description', 'like', "%{$search}%")
                                        ->orWhere('keywords', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->paginate(9)
            ->appends(['search' => $search]);

        return theme_view('categories.index', [
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    public function category($category_slug)
    {
        $category = Category::where('slug', $category_slug)
            ->with(['subCategories'])->firstOrFail();

        $searchCategories = $category->subCategories()
            ->inRandomOrder()->limit(10)->get();

        $popularSearches = $category->subCategories()
            ->orderbyDesc('views')->limit(10)->get()->shuffle();

        $businesses = BusinessController::getResultByParams($category);

        incrementViews($category, 'categories');

        return theme_view('categories.category', [
            'category' => $category,
            'searchCategories' => $searchCategories,
            'popularSearches' => $popularSearches,
            'businesses' => $businesses,
        ]);
    }

    public function subCategory($category_slug, $sub_category_slug)
    {
        $category = Category::where('slug', $category_slug)
            ->firstOrFail();

        $subCategory = SubCategory::where('category_id', $category->id)
            ->where('slug', $sub_category_slug)
            ->with('subSubCategories')
            ->firstOrFail();

        $searchCategories = $subCategory->subSubCategories()
            ->inRandomOrder()->limit(10)->get();

        $popularSearches = $subCategory->subSubCategories()
            ->orderbyDesc('views')->limit(10)->get()->shuffle();

        $businesses = BusinessController::getResultByParams($category, $subCategory);

        incrementViews($subCategory, 'sub_categories');

        return theme_view('categories.sub-category', [
            'category' => $category,
            'subCategory' => $subCategory,
            'searchCategories' => $searchCategories,
            'popularSearches' => $popularSearches,
            'businesses' => $businesses,
        ]);
    }

    public function subSubCategory($category_slug, $sub_category_slug, $sub_sub_category_slug)
    {
        $category = Category::where('slug', $category_slug)
            ->firstOrFail();

        $subCategory = SubCategory::where('category_id', $category->id)
            ->where('slug', $sub_category_slug)
            ->firstOrFail();

        $subSubCategory = SubSubCategory::where('sub_category_id', $subCategory->id)
            ->where('slug', $sub_sub_category_slug)
            ->firstOrFail();

        $searchCategories = $subCategory->subSubCategories()
            ->inRandomOrder()->limit(10)->get();

        $popularSearches = $subCategory->subSubCategories()
            ->orderbyDesc('views')->limit(10)->get()->shuffle();

        $businesses = BusinessController::getResultByParams($category, $subCategory, $subSubCategory);

        incrementViews($subCategory, 'sub_sub_categories');

        return theme_view('categories.sub-sub-category', [
            'category' => $category,
            'subCategory' => $subCategory,
            'subSubCategory' => $subSubCategory,
            'searchCategories' => $searchCategories,
            'popularSearches' => $popularSearches,
            'businesses' => $businesses,
        ]);
    }
}
