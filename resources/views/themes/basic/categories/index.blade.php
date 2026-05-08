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
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-4">
            @foreach ($categories as $category)
                <div class="col">
                    <div
                        class="category-card h-100 position-relative overflow-hidden bg-white p-4 rounded-4 d-flex flex-column">

                        {{-- Header Section --}}
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                            <div
                                class="category-icon-wrapper flex-shrink-0 rounded-4 d-flex align-items-center justify-content-center">
                                <img src="{{ $category->getImageLink() }}" alt="{{ $category->trans->name }}" class="img-fluid"
                                    style="width: 42px; height: 42px; object-fit: contain;">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1 text-dark text-truncate" style="max-width: 200px;">
                                    {{ $category->trans->name }}
                                </h5>
                                <span class="badge rounded-pill bg-primary-soft text-primary px-3 py-1 fw-medium">
                                    {{ translate_choice(':count Product|:count Products', optional($category->products)->count() ?? 0, ['count' => optional($category->products)->count() ?? 0]) }}
                                </span>
                            </div>
                            <a href="{{ $category->getLink() }}"
                                class="stretched-link-mask text-muted hover-primary transition-all">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>

                        {{-- Sub-categories List --}}
                        <div class="sub-category-list mb-4 flex-grow-1">
                            {{-- add title for sub categories --}}
                            <h6 class="fw-bold mb-3 text-dark">Sub Categories</h6>
                            <div class="row g-2">
                                @php
                                    $visibleLimit = 2; // Number of items to show before hiding the rest
                                    $totalSubCats = optional($category->subCategories)->count() ?? 0;
                                @endphp

                                {{-- Always Visible Subcategories --}}
                                @foreach ($category->subCategories->take($visibleLimit) as $subCategory)
                                    <div class="col-12">
                                        <a href="{{ $subCategory->getLink() }}"
                                            class="sub-category-link d-flex align-items-center justify-content-between px-3 py-2 rounded-3 text-decoration-none text-secondary">
                                            <span class="small fw-medium">{{ $subCategory->trans->name }}</span>
                                            <i class="fa fa-chevron-right small opacity-50 icon-rtl"></i>
                                        </a>
                                    </div>
                                @endforeach

                                {{-- Collapsible Subcategories --}}
                                @if ($totalSubCats > $visibleLimit)
                                    <div class="collapse w-100 mt-0"
                                        id="collapseCategory{{ $category->id ?? $loop->index }}">
                                        @foreach ($category->subCategories->skip($visibleLimit) as $subCategory)
                                            <div class="col-12 mt-2">
                                                <a href="{{ $subCategory->getLink() }}"
                                                    class="sub-category-link d-flex align-items-center justify-content-between px-3 py-2 rounded-3 text-decoration-none text-secondary">
                                                    <span class="small fw-medium">{{ $subCategory->trans->name }}</span>
                                                    <i class="fa fa-chevron-right small opacity-50 icon-rtl"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Expand/Collapse Button --}}
                                    <div class="col-12 mt-2">
                                        <button
                                            class="btn btn-link shadow-none text-decoration-none text-muted small fw-bold d-flex align-items-center justify-content-center gap-2 w-100 expand-toggle-btn bg-hover-light rounded-3 py-2"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseCategory{{ $category->id ?? $loop->index }}"
                                            aria-expanded="false" onclick="toggleExpandText(this)">
                                            <span class="toggle-text">{{ d_trans('Show More') }}</span>
                                            <i class="fa fa-chevron-down transition-all toggle-icon"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>


                        {{-- Footer Action --}}
                        <div class="mt-auto pt-3">
                            <a href="/products?category={{ $category->slug }}"
                                class="btn-explore w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 text-primary fw-bold text-decoration-none small text-uppercase letter-spacing-1">
                                {{ d_trans('Explore Collection') }}
                                <i class="fa fa-arrow-right icon-rtl ms-1 animate-right"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center premium-pagination">
            {{ $categories->links() }}
        </div>
    @else
        <div class="py-5">
            @include('themes.basic.partials.empty-box', ['empty_image' => 'v1'])
        </div>
    @endif
    <x-ad alias="categories_page_bottom" @class('mt-5') />
    <style>
        /* Card Container */
        .category-card {
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        /* Icon Wrapper */
        .category-icon-wrapper {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.8), 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Soft Primary Badge */
        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1) !important;
            /* Adjust RGB to match your theme's primary color */
        }

        /* Sub-category Links */
        .sub-category-link {
            transition: all 0.2s ease-in-out;
            background-color: transparent;
        }

        .sub-category-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd !important;
            /* Adjust to theme primary */
            padding-left: 1rem !important;
            /* Creates a subtle indentation effect on hover */
        }

        .sub-category-link:hover i {
            opacity: 1;
            transform: translateX(3px);
        }

        /* Explore Button */
        .btn-explore {
            background-color: transparent;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-explore:hover {
            background-color: rgba(13, 110, 253, 0.05);
            /* Adjust to theme primary */
            border-color: rgba(13, 110, 253, 0.1);
        }

        .btn-explore:hover .animate-right {
            transform: translateX(4px);
        }

        /* Utilities */
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .letter-spacing-1 {
            letter-spacing: 0.5px;
        }

        .hover-primary:hover {
            color: #0d6efd !important;
            /* Adjust to theme primary */
        }

        /* Expand/Collapse Button Styling */
        .expand-toggle-btn {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .expand-toggle-btn:hover {
            background-color: #f8f9fa;
            color: #0d6efd !important;
            /* Update this hex to match the red/pink from your screenshot */
        }

        /* Rotate icon when Bootstrap collapse is open */
        .expand-toggle-btn[aria-expanded="true"] .toggle-icon {
            transform: rotate(180deg);
        }
    </style>
    <script>
    function toggleExpandText(button) {
        const textSpan = button.querySelector('.toggle-text');
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        
        // You can replace these with your translation variables if needed
        if (isExpanded) {
            textSpan.textContent = 'Show Less';
        } else {
            textSpan.textContent = 'Show More';
        }
    }
</script>
@endsection
