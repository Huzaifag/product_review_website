@extends('themes.basic.layouts.single')
@section('title', d_trans('Explore high rated businesses'))
@section('header_title', d_trans('Explore high rated businesses'))
@section('description', d_trans('Discover top-rated businesses trusted by customers for quality and service'))
@php
    $keywords = d_trans(
        'Top-rated, trusted, businesses, reviews, quality service, customer satisfaction, best-rated, popular, highly recommended, local businesses, verified ratings, user reviews',
    );
@endphp
@section('keywords', $keywords)
@section('breadcrumbs', Breadcrumbs::render('businesses'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'businesses'))
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
                        : d_trans('All Businesses'),
                'hide_grid_buttons' => $businesses->count() < 1,
            ])
            @if ($businesses->count() > 0)
                <div class="items">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3 g-3">
                        @foreach ($businesses as $business)
                            <div class="col">
                                @include('themes.basic.partials.business', [
                                    'business' => $business,
                                    'item_footer' => true,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
                {{ $businesses->links() }}
            @else
                @include('themes.basic.partials.empty-box', ['empty_image' => 'v2'])
            @endif
            @if (config('settings.user.actions.adding_none_exists_business'))
                @if (
                    !config('settings.business.actions.reviews_require_login') ||
                        (config('settings.business.actions.reviews_require_login') && authUser()))
                    <div class="mt-4">
                        @include('themes.basic.partials.add-business-box')
                    </div>
                @endif
            @endif
        </div>
    </div>
    @include('themes.basic.categories.includes.popular-searches', ['popularSearches' => $popularSearches])
    <x-ad alias="search_page_bottom" @class('mt-5') />
@endsection
