<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::select('id', 'name')->get();

        $subSubCategories = SubSubCategory::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subSubCategories->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->OrWhere('slug', 'like', $searchTerm)
                    ->OrWhere('title', 'like', $searchTerm)
                    ->OrWhere('description', 'like', $searchTerm)
                    ->OrWhere('keywords', 'like', $searchTerm);
            });
        }

        if (request()->filled('sub_category')) {
            $subSubCategories->where('sub_category_id', request('sub_category'));
        }

        $subSubCategories = $subSubCategories->with('subCategory')->paginate(20);
        $subSubCategories->appends(request()->only(['search', 'sub_category']));

        return view('admin.categories.sub-sub-categories.index', [
            'subCategories' => $subCategories,
            'subSubCategories' => $subSubCategories,
        ]);
    }

    public function create()
    {
        $subCategories = SubCategory::select('id', 'name')->get();
        return view('admin.categories.sub-sub-categories.create', [
            'subCategories' => $subCategories,
        ]);
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(SubSubCategory::class, 'slug', $request->content);
        }

        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_category' => ['required', 'integer', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $existsSubSubCategory = SubSubCategory::where('sub_category_id', $request->sub_category)
            ->where(function ($query) use ($request) {
                $query->where('name', $request->name)
                    ->orWhere('slug', $request->slug);
            })
            ->exists();
        if ($existsSubSubCategory) {
            toastr()->error(d_trans('Sub Sub category with the same name or slug already exists'));
            return back()->withInput();
        }

        $subSubCategory = new SubSubCategory();
        $subSubCategory->name = $request->name;
        $subSubCategory->slug = $request->slug;
        $subSubCategory->title = $request->title;
        $subSubCategory->description = $request->description;
        $subSubCategory->keywords = $request->keywords;
        $subSubCategory->sub_category_id = $request->sub_category;
        $subSubCategory->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.categories.sub-sub-categories.edit', $subSubCategory->id);
    }

    public function edit(SubSubCategory $subSubCategory)
    {
        $subCategories = SubCategory::select('id', 'name')->get();
        return view('admin.categories.sub-sub-categories.edit', [
            'subSubCategory' => $subSubCategory,
            'subCategories' => $subCategories,
        ]);
    }

    public function update(Request $request, SubSubCategory $subSubCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $existsSubSubCategory = SubSubCategory::where('sub_category_id', $subSubCategory->sub_category->id)
            ->where(function ($query) use ($request) {
                $query->where('name', $request->name)
                    ->orWhere('slug', $request->slug);
            })
            ->where('id', '!=', $subSubCategory->id)
            ->exists();
        if ($existsSubSubCategory) {
            toastr()->error(d_trans('Sub Sub category with the same name or slug already exists'));
            return back()->withInput();
        }

        $subSubCategory->name = $request->name;
        $subSubCategory->slug = $request->slug;
        $subSubCategory->title = $request->title;
        $subSubCategory->description = $request->description;
        $subSubCategory->keywords = $request->keywords;
        $subSubCategory->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(SubSubCategory $subSubCategory)
    {
        $subSubCategory->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}
