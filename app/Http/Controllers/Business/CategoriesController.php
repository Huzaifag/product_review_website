<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        $business = currentBusiness();

        $modalSubCategories = SubCategory::where('category_id', $business->category->id)
            ->select('slug', 'name')
            ->with('category')
            ->get();

        $businessSubSubCategoryIds = $business->subSubCategories()->pluck('sub_sub_categories.id');

        $searchTerm = request()->get('search', '');

        $subCategories = SubCategory::where('category_id', $business->category->id)
            ->whereIn('id', function ($query) use ($businessSubSubCategoryIds) {
                $query->select('sub_category_id')
                    ->from('sub_sub_categories')
                    ->whereIn('id', $businessSubSubCategoryIds);
            })
            ->where(function ($query) use ($searchTerm, $businessSubSubCategoryIds) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('keywords', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('subSubCategories', function ($q) use ($searchTerm, $businessSubSubCategoryIds) {
                        $q->whereIn('id', $businessSubSubCategoryIds)
                            ->where(function ($q2) use ($searchTerm) {
                                $q2->where('name', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('title', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('keywords', 'like', '%' . $searchTerm . '%');
                            });
                    });
            })
            ->paginate(20);

        $subCategories->appends(request()->only(['search']));

        $tableCategories = $subCategories->map(function ($subCategory) use ($businessSubSubCategoryIds) {
            $subSubCategories = $subCategory->subSubCategories()
                ->whereIn('id', $businessSubSubCategoryIds)
                ->get();

            return [
                'subCategory' => [
                    'name' => $subCategory->trans->name,
                    'slug' => $subCategory->slug,
                ],
                'subSubCategories' => $subSubCategories->pluck('name')->toArray(),
            ];
        });

        return theme_view('business.categories', [
            'subCategories' => $subCategories,
            'tableCategories' => $tableCategories,
            'modalSubCategories' => $modalSubCategories,
        ]);
    }

    public function store(Request $request)
    {
        $business = currentBusiness();

        $validator = Validator::make($request->all(), [
            'category' => ['required', 'string', 'exists:sub_categories,slug'],
            'sub_categories' => ['required', 'array'],
            'sub_categories.*' => ['required', 'exists:sub_sub_categories,slug'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $subCategory = SubCategory::where('category_id', $business->category->id)
            ->where('slug', $request->category)->firstOrFail();

        $subSubCategories = [];
        $alreadyAttached = false;

        foreach ($request->sub_categories as $sub_category) {
            $subSubCategory = SubSubCategory::where('sub_category_id', $subCategory->id)
                ->where('slug', $sub_category)->firstOrFail();

            if ($business->subSubCategories->contains('id', $subSubCategory->id)) {
                $alreadyAttached = true;
                toastr()->error(d_trans('This subsubcategory has already been added.'));
                return back();
            }

            $subSubCategories[] = $subSubCategory->id;
        }

        if (!$alreadyAttached) {
            $business->subSubCategories()->attach($subSubCategories);
            toastr()->success(d_trans('The category has been added successfully.'));
        }

        return back();
    }

    public function destroy($slug)
    {
        $business = currentBusiness();

        $subCategory = SubCategory::where('category_id', $business->category->id)
            ->where('slug', $slug)->firstOrFail();

        $subSubIds = $subCategory->subSubCategories->pluck('id');
        $business->subSubCategories()->detach($subSubIds);

        toastr()->success(d_trans('The category has been deleted successfully.'));
        return back();

    }

    public function loadSubCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => ['required', 'string', 'exists:sub_categories,slug'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $business = currentBusiness();

        $subCategory = SubCategory::where('category_id', $business->category->id)
            ->where('slug', $request->category)->firstOrFail();

        $attachedSubSubCategoryIds = $business->subSubCategories()
            ->where('sub_category_id', $subCategory->id)
            ->pluck('sub_sub_categories.id')
            ->toArray();

        $subSubCategories = SubSubCategory::where('sub_category_id', $subCategory->id)
            ->whereNotIn('id', $attachedSubSubCategoryIds)
            ->select('slug', 'name')
            ->get();

        return response()->json($subSubCategories);
    }

}