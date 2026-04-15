@extends('themes.basic.layouts.single')
@section('title', d_trans('Explore high rated products'))
@section('header_title', d_trans('Explore high rated products'))
@section('description', d_trans('Discover top-rated products trusted by customers for quality and service'))
@php
    $keywords = d_trans(
        'Top-rated, trusted, products, reviews, quality service, customer satisfaction, best-rated, popular, highly recommended, verified ratings, user reviews',
    );
@endphp
@section('keywords', $keywords)
@section('breadcrumbs', Breadcrumbs::render('products'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'products'))
@section('container', 'container-custom')
@section('header_v1', true)
@section('content')
    <x-ad alias="search_page_top" @class('mb-5') />
    <div class="row g-4">
        @include('themes.basic.partials.search-params', [
            'search_params_classes' => 'col-lg-4 col-xxl-3',
            'search_categories' => $searchCategories,
        ])
        <div class="col-lg-8 col-xxl-9">
            @include('themes.basic.partials.grid-header', [
                'grid_title' =>
                    collect(request()->query())->except('page')->count() > 0
                        ? d_trans('Your search results')
                        : d_trans('All Products'),
                'hide_grid_buttons' => $products->count() < 1,
            ])
            @if ($products->count() > 0)
                <div class="items">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3 g-3">
                        @foreach ($products as $product)
                            <div class="col">
                                @include('themes.basic.partials.product', [
                                    'product' => $product,
                                    'item_footer' => true,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
                {{ $products->links() }}
                @include('themes.basic.categories.includes.popular-searches', ['popularSearches' => $popularSearches])
            @else
                @include('themes.basic.partials.empty-box', ['empty_image' => 'v2'])
            @endif
        </div>
    </div>
    <x-ad alias="search_page_bottom" @class('mt-5') />
@endsection
