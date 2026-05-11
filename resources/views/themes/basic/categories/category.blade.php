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
        <div class="col-12">
            @if (!empty($category->description))
                <div class="category-description mb-4">
                    <h3>{{ $category->trans->title ?? $category->trans->name }}</h3>
                    <p>{{ $category->description }}</p>
                </div>
            @endif
            @if (!empty($category->guide))
                <div class="category-guide">
                    <div class="guide-header">
                        <i class="fas fa-book-open guide-icon"></i>
                        <div>
                            <h4 class="guide-title">{{ d_trans('Expert Guide') }}</h4>
                            <p class="guide-subtitle">{{ d_trans('Tips and insights for this category.') }}</p>
                        </div>
                    </div>
                    <div class="guide-list">
                        @foreach ($category->guide as $index => $tip)
                            <div class="guide-item">
                                <span class="guide-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <p>{{ $tip }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
           
            @if ($sub_categories && $sub_categories->count() > 0)
                @include('themes.basic.categories.includes.sub_categories', ['sub_categories' => $sub_categories])
            @endif
        </div>
        @include('themes.basic.partials.search-params', [
            'search_params_classes' => 'col-lg-4 col-xxl-3',
            'search_categories_title' => d_trans('Related Categories'),
            'search_categories' => $searchCategories,
            'search_brands' => $search_brands,
        ])
        
        <div class="col-lg-8 col-xxl-9">
            @include('themes.basic.partials.grid-header', [
                'grid_title' => '',
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

<style>
    .category-guide {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 16px;
        padding: 2rem;
        margin-top: 2rem;
        border: 1px solid #dee2e6;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }

    .guide-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .guide-icon {
        font-size: 2.5rem;
        color: #1D9E75;
    }

    .guide-title {
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        color: #212529;
    }

    .guide-subtitle {
        font-size: 1rem;
        color: #6c757d;
        margin: 0;
    }

    .guide-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .guide-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        padding: 1.5rem;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .guide-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }

    .guide-num {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1D9E75;
        line-height: 1;
    }

    .guide-item p {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.6;
        color: #495057;
    }
</style>
