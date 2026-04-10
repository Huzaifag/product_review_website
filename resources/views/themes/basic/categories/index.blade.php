@extends('themes.basic.layouts.single')
@section('header_title', d_trans('Categories'))
@section('title', d_trans('Categories'))
@section('breadcrumbs', Breadcrumbs::render('categories'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'categories'))
@section('container', 'container-custom')
@section('header_v3', true)
@section('content')
    <x-ad alias="categories_page_top" @class('mb-5') />
    @if ($categories->count() > 0)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3">
            @foreach ($categories as $category)
                <div class="col">
                    <div class="category box">
                        <a href="{{ $category->getLink() }}"
                            class="category-header d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
                            <div class="category-icon mb-0 flex-shrink-0">
                                <img src="{{ $category->getImageLink() }}" alt="{{ $category->trans->name }}">
                            </div>
                            <div class="mt-1">
                                <h5 class="category-title mb-2">{{ $category->trans->name }}</h5>
                                <p class="category-text mb-0">
                                    {{ translate_choice(':count Business|:count Businesses', $category->businesses_count, ['count' => $category->businesses_count]) }}
                                </p>
                            </div>
                        </a>
                        <div class="mb-4">
                            <div class="row row-cols-1 g-3">
                                @foreach ($category->subCategories as $subCategory)
                                    <div class="col">
                                        <a href="{{ $subCategory->getLink() }}" class="category-item">
                                            {{ $subCategory->trans->name }}
                                            <i class="fa fa-chevron-right icon-rtl"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ $category->getLink() }}" class="category-action pt-4 border-top">
                            <small>{{ d_trans('View Businesses') }}</small>
                            <i class="fa fa-arrow-right icon-rtl ms-2"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $categories->links() }}
    @else
        @include('themes.basic.partials.empty-box', ['empty_image' => 'v1'])
    @endif
    <x-ad alias="categories_page_bottom" @class('mt-5') />
@endsection
