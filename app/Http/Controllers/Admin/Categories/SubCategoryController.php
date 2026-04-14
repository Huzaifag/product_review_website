<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

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
                    ->orWhere('slug', 'like', $searchTerm)
                    ->orWhere('title', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('keywords', 'like', $searchTerm);
            });
        }

        if (request()->filled('category')) {
            $subCategories->where('category_id', request('category'));
        }

        $subCategories = $subCategories->with('category')
            ->withCount('subSubCategories')
            ->paginate(20)
            ->appends(request()->only(['search', 'category']));

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
        if ($request->filled('content')) {
            $slug = SlugService::createSlug(SubCategory::class, 'slug', $request->content);
        }

        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category'    => ['required', 'integer', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'alpha_dash', 'max:255'],
            'image'       => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'title'       => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'keywords'    => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        // Check for duplicate name or slug in the same category
        $exists = SubCategory::where('category_id', $request->category)
            ->where(function ($q) use ($request) {
                $q->where('name', $request->name)
                  ->orWhere('slug', $request->slug);
            })
            ->exists();

        if ($exists) {
            toastr()->error(d_trans('Sub category with the same name or slug already exists'));
            return back()->withInput();
        }

        $image = null;
        if ($request->hasFile('image')) {
            try {
                $image = FileHandler::upload($request->file('image'), [
                    'path' => 'images/sub-categories/',
                ]);
            } catch (Exception $e) {
                toastr()->error($e->getMessage());
                return back()->withInput();
            }
        }

        $subCategory = SubCategory::create([
            'category_id' => $request->category,
            'name'        => $request->name,
            'slug'        => $request->slug,
            'image'       => $image,
            'title'       => $request->title,
            'description' => $request->description,
            'keywords'    => $request->keywords,
        ]);

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.categories.sub-categories.edit', $subCategory->id);
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::select('id', 'name')->get();

        return view('admin.categories.sub-categories.edit', [
            'subCategory' => $subCategory,
            'categories'  => $categories,
        ]);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        
        $validator = Validator::make($request->all(), [
            'category'    => ['required', 'integer', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'alpha_dash', 'max:255'],
            'image'       => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'title'       => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'keywords'    => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        // Check duplicate (exclude current record)
        $exists = SubCategory::where('category_id', $request->category)
            ->where(function ($q) use ($request) {
                $q->where('name', $request->name)
                  ->orWhere('slug', $request->slug);
            })
            ->where('id', '!=', $subCategory->id)
            ->exists();

        if ($exists) {
            toastr()->error(d_trans('Sub category with the same name or slug already exists'));
            return back()->withInput();
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $image = FileHandler::upload($request->file('image'), [
                    'path' => 'images/sub-categories/',
                ]);
                $subCategory->image = $image;
            } catch (Exception $e) {
                toastr()->error($e->getMessage());
                return back()->withInput();
            }
        }

        $subCategory->update([
            'category_id' => $request->category,
            'name'        => $request->name,
            'slug'        => $request->slug,
            'title'       => $request->title,
            'description' => $request->description,
            'keywords'    => $request->keywords,
        ]);

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(SubCategory $subCategory)
    {
       // Optional: Delete image if you want
        if ($subCategory->image) {
            FileHandler::delete($subCategory->image);
        }

        $subCategory->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}