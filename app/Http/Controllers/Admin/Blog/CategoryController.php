<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $categories->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->OrWhere('title', 'like', $searchTerm)
                    ->OrWhere('slug', 'like', $searchTerm)
                    ->OrWhere('body', 'like', $searchTerm)
                    ->OrWhere('description', 'like', $searchTerm)
                    ->OrWhere('keywords', 'like', $searchTerm);
            });
        }

        $categories = $categories->withCount('articles')
            ->orderbyDesc('id')->paginate(50);
        $categories->appends(request()->only(['search']));

        return view('admin.blog.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.blog.categories.create');
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(BlogCategory::class, 'slug', $request->content);
        }

        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'slug' => ['required', 'string', 'unique:blog_categories', 'alpha_dash'],
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

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->title = $request->title;
        $category->description = $request->description;
        $category->keywords = $request->keywords;
        $category->lang = getLocale();
        $category->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.blog.categories.edit', $category->id);
    }

    public function edit(BlogCategory $category)
    {
        return view('admin.blog.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, BlogCategory $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'slug' => ['required', 'string', 'alpha_dash', 'unique:blog_categories,slug,' . $category->id],
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

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->title = $request->title;
        $category->description = $request->description;
        $category->keywords = $request->keywords;
        $category->save();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(BlogCategory $category)
    {
        if ($category->articles->count() > 0) {
            toastr()->error(d_trans('The selected category has articles, it cannot be deleted'));
            return back();
        }

        $category->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}