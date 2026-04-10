<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $categories->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->OrWhere('slug', 'like', $searchTerm)
                    ->OrWhere('title', 'like', $searchTerm)
                    ->OrWhere('description', 'like', $searchTerm)
                    ->OrWhere('keywords', 'like', $searchTerm);
            });
        }

        $categories = $categories->withCount('subCategories')->paginate(20);
        $categories->appends(request()->only(['search']));

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(Category::class, 'slug', $request->content);
        }

        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:categories', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'unique:categories', 'max:255'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
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

        try {
            $image = FileHandler::upload($request->file('image'), [
                'path' => 'images/categories/',
            ]);
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->image = $image;
        $category->title = $request->title;
        $category->description = $request->description;
        $category->keywords = $request->keywords;
        $category->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.categories.edit', $category->id);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
            'slug' => ['required', 'string', 'alpha_dash', 'max:255', 'unique:categories,slug,' . $category->id],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
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

        try {
            if ($request->hasFile('image')) {
                $image = FileHandler::upload($request->file('image'), [
                    'path' => 'images/categories/',
                    'old_file' => $category->image,
                ]);
            } else {
                $image = $category->image;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->image = $image;
        $category->title = $request->title;
        $category->description = $request->description;
        $category->keywords = $request->keywords;
        $category->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(Category $category)
    {
        FileHandler::delete($category->image);

        $category->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}
