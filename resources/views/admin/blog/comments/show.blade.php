@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Blog'))
@section('title', d_trans('Comments'))
@section('header_title', d_trans('Comment #:comment_id', ['comment_id' => $comment->id]))
@section('back', route('admin.blog.comments.index'))
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <div class="bg-light border rounded-3 p-4 mb-4">
                <h6 class="mb-3">
                    <strong>{{ d_trans('Article:') }}</strong>
                </h6>
                <a href="{{ route('admin.blog.articles.edit', $comment->article->id) }}" target="_blank"><i
                        class="fa-solid fa-arrow-up-right-from-square me-2"></i>{{ $comment->article->title }}</a>
            </div>
            <div class="bg-light border rounded-3 p-4 mb-4">
                <h6 class="mb-3">
                    <strong>{{ d_trans('Comment:') }}</strong>
                </h6>
                {!! purifier($comment->body) !!}
            </div>
            <div class="row g-3">
                @if ($comment->isPending())
                    <div class="col-lg-6">
                        <form action="{{ route('admin.blog.comments.update', $comment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary btn-md w-100 action-confirm"><i
                                    class="fa-regular fa-circle-check me-2"></i>{{ d_trans('Publish') }}</button>
                        </form>
                    </div>
                @endif
                <div class="{{ $comment->isPending() ? 'col-lg-6' : 'col-lg-12' }}">
                    <form action="{{ route('admin.blog.comments.destroy', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-md w-100 action-confirm"><i
                                class="fa-regular fa-trash-can me-2"></i>{{ d_trans('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
