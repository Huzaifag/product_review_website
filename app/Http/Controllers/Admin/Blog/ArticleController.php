<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::all();

        $articles = BlogArticle::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $articles->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                    ->orWhere('slug', 'like', $searchTerm)
                    ->orWhere('body', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->OrWhere('keywords', 'like', $searchTerm);
            });
        }

        if (request()->filled('category')) {
            $articles->where('blog_category_id', request('category'));
        }

        $articles = $articles->with('category')->withCount('comments')
            ->orderbyDesc('id')->paginate(50);
        $articles->appends(request()->only(['search', 'category']));

        return view('admin.blog.articles.index', [
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.articles.create', [
            'categories' => $categories,
        ]);
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(BlogArticle::class, 'slug', $request->content);
        }
        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'unique:blog_articles'],
            'body' => ['required', 'string'],
            'category' => ['required', 'integer', 'exists:blog_categories,id'],
            'image' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
            'description' => ['required', 'string', 'max:255'],
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
                'path' => 'images/blog/',
            ]);
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }

        $article = new BlogArticle();
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->body = $request->body;
        $article->image = $image;
        $article->description = $request->description;
        $article->keywords = $request->keywords;
        $article->blog_category_id = $request->category;
        $article->lang = getLocale();
        $article->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.blog.articles.edit', $article->id);
    }

    public function edit(BlogArticle $article)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.articles.edit', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, BlogArticle $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'unique:blog_categories,slug,' . $article->id],
            'body' => ['required', 'string'],
            'category' => ['required', 'integer', 'exists:blog_categories,id'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:2048'],
            'description' => ['required', 'string', 'max:255'],
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
                    'path' => 'images/blog/',
                    'old_file' => $article->image,
                ]);
            } else {
                $image = $article->image;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }

        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->body = $request->body;
        $article->image = $image;
        $article->description = $request->description;
        $article->keywords = $request->keywords;
        $article->blog_category_id = $request->category;
        $article->save();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(BlogArticle $article)
    {
        FileHandler::delete($article->image);

        $article->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}