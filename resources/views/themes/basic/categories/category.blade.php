@extends('themes.basic.layouts.single')
@section('title', $category->trans->title ?? $category->trans->name)
@section('header_title', $category->trans->title ?? $category->trans->name)
@section('description', $category->trans->description)
@section('keywords', $category->trans->keywords)
@section('breadcrumbs', Breadcrumbs::render('categories.category', $category))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'categories.category', $category))
@section('container', 'container-custom')
@section('header_v1', true)
@section('content')
    <x-ad alias="categories_page_top" @class('mb-5') />
    <div class="row g-4">
        @include('themes.basic.partials.search-params', [
            'search_params_classes' => 'col-lg-4 col-xxl-3',
            'search_categories_title' => d_trans('Related Categories'),
            'search_categories' => $searchCategories,
        ])
        <div class="col-lg-8 col-xxl-9">
            @include('themes.basic.partials.grid-header', [
                'grid_title' =>
                    collect(request()->query())->except('page')->count() > 0
                        ? d_trans('Your search results for the ":name" category', [
                            'name' => strtolower($category->trans->name),
                        ])
                        : d_trans('All results for the ":name" category', [
                            'name' => strtolower($category->trans->name),
                        ]),
                'hide_grid_buttons' => $products->count() < 1,
            ])
            @if ($products->count() > 0)
                <div class="items">
                    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2 g-3">
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
            @else
                @include('themes.basic.partials.empty-box', ['empty_image' => 'v2'])
            @endif
            {{-- @if (config('settings.user.actions.adding_none_exists_business'))
                @if (!config('settings.business.actions.reviews_require_login') || (config('settings.business.actions.reviews_require_login') && authUser()))
                    <div class="mt-4">
                        @include('themes.basic.partials.add-business-box')
                    </div>
                @endif
            @endif --}}
        </div>
    </div>
    @include('themes.basic.categories.includes.popular-searches', ['popularSearches' => $popularSearches])
    <x-ad alias="categories_page_bottom" @class('mt-5') />
@endsection
