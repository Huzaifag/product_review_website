<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = BlogComment::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $comments->where(function ($query) use ($searchTerm) {
                $query->whereHas('article', function ($query) use ($searchTerm) {
                    $query->where('title', 'like', $searchTerm)
                        ->orWhere('slug', 'like', $searchTerm)
                        ->orWhere('body', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhereHas('category', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', $searchTerm)
                                ->orWhere('slug', 'like', $searchTerm);
                        });
                });
            });
        }

        if (request()->filled('status')) {
            $comments->where('status', request('status'));
        }

        if (request()->filled('article')) {
            $comments->where('blog_article_id', request('article'));
        }

        $comments = $comments->with('article')->orderbyDesc('id')->paginate(50);
        $comments->appends(request()->only(['search', 'status', 'article']));

        return view('admin.blog.comments.index', [
            'comments' => $comments,
        ]);
    }

    public function show(BlogComment $comment)
    {
        return view('admin.blog.comments.show', [
            'comment' => $comment,
        ]);
    }

    public function update(Request $request, BlogComment $comment)
    {
        if ($comment->isPending()) {
            $comment->status = BlogComment::STATUS_PUBLISHED;
            $comment->save();
        }

        return back();
    }

    public function destroy(BlogComment $comment)
    {
        $comment->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return redirect()->route('admin.blog.comments.index');
    }
}
