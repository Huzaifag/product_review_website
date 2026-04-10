<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $pages->where('title', 'like', $searchTerm)
                ->OrWhere('slug', 'like', $searchTerm)
                ->OrWhere('body', 'like', $searchTerm)
                ->OrWhere('description', 'like', $searchTerm)
                ->OrWhere('keywords', 'like', $searchTerm);
        }

        $pages = $pages->orderbyDesc('id')->paginate(50);
        $pages->appends(request()->only(['search']));

        return view('admin.settings.pages.index', ['pages' => $pages]);
    }

    public function create()
    {
        return view('admin.settings.pages.create');
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(Page::class, 'slug', $request->content);
        }

        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'unique:pages'],
            'body' => ['required'],
            'description' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $page = new Page();
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->body = $request->body;
        $page->description = $request->description;
        $page->keywords = $request->keywords;
        $page->lang = getLocale();
        $page->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.settings.pages.edit', $page->id);
    }

    public function edit(Page $page)
    {
        return view('admin.settings.pages.edit', ['page' => $page]);
    }

    public function update(Request $request, Page $page)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'unique:pages,slug,' . $page->id],
            'body' => ['required'],
            'description' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->body = $request->body;
        $page->description = $request->description;
        $page->keywords = $request->keywords;
        $page->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(Page $page)
    {
        $page->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}