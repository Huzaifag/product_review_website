@extends('themes.basic.blog.layout')
@section('title', $blogArticle->title)
@section('description', $blogArticle->description)
@section('keywords', $blogArticle->keywords)
@section('og_image', $blogArticle->getImageLink())
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'blog_article', $blogArticle))
@section('content')
    <div class="blog-container">
        <div class="blog-post v2 blog-post-single">
            <div class="text-center mb-4">
                <div class="blog-post-meta">
                    <div class="row row-cols-auto align-items-center justify-content-center gx-3 gy-2">
                        @php
                            $blogCategory = $blogArticle->category;
                        @endphp
                        <div class="col">
                            <a href="{{ $blogCategory->getLink() }}" class="blog-post-category mb-0"><i
                                    class="bi bi-tag icon-rtl me-2"></i>{{ $blogCategory->name }}</a>
                        </div>
                        <div class="col d-flex align-items-center text-muted small">
                            <i class="fa-regular fa-calendar me-2"></i>
                            <span>{{ dateFormat($blogArticle->created_at) }}</span>
                        </div>
                    </div>
                </div>
                <h1 class="blog-post-title px-2 mb-0">{{ $blogArticle->title }}</h1>
            </div>
            <div class="blog-post-header">
                <img src="{{ $blogArticle->getImageLink() }}" alt="{{ $blogArticle->title }}" class="blog-post-img">
            </div>
            <div class="blog-post-body px-sm-4">
                <x-ad alias="blog_article_page_top" @class('mb-4') />
                {!! $blogArticle->body !!}
                <x-ad alias="blog_article_page_bottom" @class('mt-3 mb-4') />
                @include('themes.basic.partials.share-buttons', [
                    'socials_classes' => 'mt-3 mb-4',
                    'link' => $blogArticle->getLink(),
                ])
                <div class="comments">
                    <h5 class="comments-title">
                        <i class="far fa-comments me-2"></i>{{ d_trans('Comments') }}
                        ({{ $blogArticleComments->count() }})
                    </h5>
                    @forelse ($blogArticleComments as $blogArticleComment)
                        @php
                            $user = $blogArticleComment->user;
                        @endphp
                        <div class="box box-bg p-4 mb-3">
                            <div class="comment">
                                <div class="comment-info">
                                    <a href="{{ $user->getProfileLink() }}" class="comment-img">
                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="{{ $user->getProfileLink() }}" class="h6 comment-title mb-1">
                                            {{ $user->getName() }}
                                        </a>
                                        <time class="comment-time small text-muted">
                                            <i
                                                class="fa-regular fa-calendar me-2"></i>{{ dateFormat($blogArticleComment->created_at) }}
                                        </time>
                                    </div>
                                </div>
                                <p class="comment-text mb-0 text-muted">
                                    {!! purifier($blogArticleComment->body) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="box box-bg p-4">
                    @if (authUser())
                        <h5 class="mb-4">{{ d_trans('Leave a comment') }}</h5>
                        <form action="{{ $blogArticle->getLink() }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control form-control-md" name="comment" rows="4"
                                    placeholder="{{ d_trans('Your comment') }}" required>{{ old('comment') }}</textarea>
                            </div>
                            <x-captcha />
                            <button class="btn btn-primary btn-md px-5">{{ d_trans('Publish') }}</button>
                        </form>
                    @else
                        <div class="text-center">
                            {{ d_trans('Login or create account to leave comments') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('schema')
        {!! schema($__env, 'article', ['article' => $blogArticle]) !!}
    @endpush
@endsection
