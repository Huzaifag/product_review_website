<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')->get();

        $subCategories = SubCategory::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subCategories->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->OrWhere('slug', 'like', $searchTerm)
                    ->OrWhere('title', 'like', $searchTerm)
                    ->OrWhere('description', 'like', $searchTerm)
                    ->OrWhere('keywords', 'like', $searchTerm);
            });
        }

        if (request()->filled('category')) {
            $subCategories->where('category_id', request('category'));
        }

        $subCategories = $subCategories->with('category')
            ->withCount('subSubCategories')->paginate(20);
        $subCategories->appends(request()->only(['search', 'category']));

        return view('admin.categories.sub-categories.index', [
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.categories.sub-categories.create', [
            'categories' => $categories,
        ]);
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(SubCategory::class, 'slug', $request->content);
        }

        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => ['required', 'integer', 'exists:categories,id'],
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

        $existsSubCategory = SubCategory::where('category_id', $request->category)
            ->where(function ($query) use ($request) {
                $query->where('name', $request->name)
                    ->orWhere('slug', $request->slug);
            })
            ->exists();
        if ($existsSubCategory) {
            toastr()->error(d_trans('Sub category with the same name or slug already exists'));
            return back()->withInput();
        }

        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->title = $request->title;
        $subCategory->description = $request->description;
        $subCategory->keywords = $request->keywords;
        $subCategory->category_id = $request->category;
        $subCategory->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.categories.sub-categories.edit', $subCategory->id);
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.categories.sub-categories.edit', [
            'subCategory' => $subCategory,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, SubCategory $subCategory)
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

        $existsSubCategory = SubCategory::where('category_id', $subCategory->category->id)
            ->where(function ($query) use ($request) {
                $query->where('name', $request->name)
                    ->orWhere('slug', $request->slug);
            })
            ->where('id', '!=', $subCategory->id)
            ->exists();
        if ($existsSubCategory) {
            toastr()->error(d_trans('Sub category with the same name or slug already exists'));
            return back()->withInput();
        }

        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->title = $request->title;
        $subCategory->description = $request->description;
        $subCategory->keywords = $request->keywords;
        $subCategory->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}
