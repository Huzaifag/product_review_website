@extends('themes.basic.blog.layout')
@section('title', d_trans('Blog'))
@section('header_title', d_trans('Blog'))
@section('breadcrumbs', Breadcrumbs::render('blog'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'blog'))
@section('header', true)
@section('content')
    <x-ad alias="blog_page_top" @class('mb-5') />
    @if ($blogArticles->count() > 0)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 g-3">
            @foreach ($blogArticles as $blogArticle)
                <div class="col">
                    @include('themes.basic.partials.blog-post', [
                        'blogArticle' => $blogArticle,
                    ])
                </div>
            @endforeach
        </div>
        {{ $blogArticles->links() }}
    @else
        <div class="box p-5 text-center">
            <span class="text-muted">{{ d_trans('No blog articles found') }}</span>
        </div>
    @endif
    <x-ad alias="blog_page_bottom" @class('mt-5') />
@endsection
