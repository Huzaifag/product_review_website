@extends('themes.basic.layouts.single')
@section('title', $subCategory->trans->title ?? $subCategory->trans->name)
@section('header_title', $subCategory->trans->title ?? $subCategory->trans->name)
@section('description', $subCategory->trans->description)
@section('keywords', $subCategory->trans->keywords)
@section('breadcrumbs', Breadcrumbs::render('categories.sub-category', $subCategory))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'categories.sub-category', $subCategory))
@section('container', 'container-custom')
@section('header_v1', true)
@section('content')
    <x-ad alias="categories_page_top" @class('mb-5') />
    <div class="row g-4">
        <div class="col-12">
            @if (!empty($subCategory->description))
                <div class="category-description mb-4">
                    <h3>{{ $subCategory->trans->title ?? $subCategory->trans->name }}</h3>
                    <p>{{ $subCategory->description }}</p>
                </div>
            @endif
            @if (!empty($subCategory->guide))
                <div class="category-guide">
                    <div class="guide-header">
                        <i class="fas fa-book-open guide-icon"></i>
                        <div>
                            <h4 class="guide-title">{{ d_trans('Expert Guide') }}</h4>
                            <p class="guide-subtitle">{{ d_trans('Tips and insights for this category.') }}</p>
                        </div>
                    </div>
                    <div class="guide-list">
                        @foreach ($subCategory->guide as $index => $tip)
                            <div class="guide-item">
                                <span class="guide-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <p>{{ $tip }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
           
            {{-- @if ($subCategory->subSubCategories && $subCategory->subSubCategories->count() > 0)
                @include('themes.basic.categories.includes.sub_categories', ['sub_categories' => $subCategory->subSubCategories])
            @endif --}}
        </div>
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
                            'name' => strtolower($subCategory->trans->name),
                        ])
                        : d_trans('All results for the ":name" category', [
                            'name' => strtolower($subCategory->trans->name),
                        ]),
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
            @else
                @include('themes.basic.partials.empty-box', ['empty_image' => 'v2'])
            @endif
        </div>
    </div>
    @include('themes.basic.categories.includes.popular-searches', ['popularSearches' => $popularSearches])
    <x-ad alias="categories_page_bottom" @class('mt-5') />
@endsection

@push('styles')
    <style>
        .category-description {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .category-guide {
            background-color: #fff3cd;
            padding: 20px;
            border-radius: 8px;
        }

        .guide-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .guide-icon {
            font-size: 30px;
            color: #856404;
        }

        .guide-title {
            margin-bottom: 0;
            color: #856404;
        }

        .guide-subtitle {
            margin-bottom: 0;
            color: #856404;
        }

        .guide-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .guide-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .guide-num {
            font-weight: bold;
            color: #856404;
        }
    </style>