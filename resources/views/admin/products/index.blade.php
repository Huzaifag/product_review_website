@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('Products'))
@section('header_title', d_trans('Products'))
@section('content')
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i>{{ d_trans('Add Product') }}
        </a>
    </div>



    <div class="row g-3 row-cols-md-2 row-cols-xxl-4 mb-4">
        <div class="col">
            <div class="split-stat-card theme-brand-base">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Active') }}</p>
                    <h3 class="split-card-number">{{ $counters['active'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-copper">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Inactive') }}</p>
                    <h3 class="split-card-number">{{ $counters['inactive'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="fa-solid fa-ban"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-clay">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Featured') }}</p>
                    <h3 class="split-card-number">{{ $counters['featured'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-sienna">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Lab Verified') }}</p>
                    <h3 class="split-card-number">{{ $counters['lab_verified'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="fa-solid fa-flask-vial"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET" id="productFiltersForm">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="category" class="selectpicker" title="{{ d_trans('Category') }}">
                            <option value="">{{ d_trans('All') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == "$category->id")>
                                    {{ $category->trans->name ?? $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="sub_category" class="selectpicker" title="{{ d_trans('Sub Category') }}">
                            <option value="">{{ d_trans('All') }}</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @selected(request('sub_category') == "$subCategory->id")>
                                    {{ $subCategory->trans->name ?? $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="brand" class="selectpicker" title="{{ d_trans('Brand') }}">
                            <option value="">{{ d_trans('All') }}</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(request('brand') == "$brand->id")>
                                    {{ $brand->name ?? $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            <option value="">{{ d_trans('All') }}</option>
                            <option value="1" @selected(request('status') === '1')>{{ d_trans('Active') }}</option>
                            <option value="0" @selected(request('status') === '0')>{{ d_trans('Inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="featured" class="selectpicker" title="{{ d_trans('Featured') }}">
                            <option value="">{{ d_trans('All') }}</option>
                            <option value="1" @selected(request('featured') === '1')>{{ d_trans('Yes') }}</option>
                            <option value="0" @selected(request('featured') === '0')>{{ d_trans('No') }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-soft w-100">{{ d_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th><i class="fa-solid fa-hashtag"></i></th>
                        <th>{{ d_trans('Name') }}</th>
                        <th class="text-center">{{ d_trans('Brand') }}</th>
                        <th class="text-center">{{ d_trans('Category') }}</th>
                        <th class="text-center">{{ d_trans('Sub Category') }}</th>
                        <th class="text-center">{{ d_trans('Grade') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Added date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $product->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                        class="item-title d-block fw-normal mb-0">
                                        {{ $product->name }}
                                    </a>
                                    <p class="item-text text-muted small mb-0">{{ $product->slug }}</p>
                                </td>
                                <td class="text-center">{{ $product->brand->name ?? '-' }}</td>
                                <td class="text-center">{{ $product->category->trans->name ?? '-' }}</td>
                                <td class="text-center">{{ $product->subCategory->trans->name ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($product->overall_grade)
                                        <span
                                            class="badge bg-c21">{{ str_replace('_', ' ', ucfirst($product->overall_grade)) }}</span>
                                    @else
                                        <span>--</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($product->is_active)
                                        <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ d_trans('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($product->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.products.show', $product->id) }}">
                                                    <i class="fas fa-desktop"></i>{{ d_trans('View Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.products.edit', $product->id) }}">
                                                    <i class="fas fa-pen"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="action-confirm dropdown-item text-danger">
                                                        <i class="far fa-trash-alt"></i>{{ d_trans('Delete') }}
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 9])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <style>
            /* --- Split Layout Stat Cards --- */

            .split-stat-card {
                position: relative;
                display: flex;
                align-items: center;
                border-radius: 8px;
                padding: 24px 20px;
                color: #ffffff;
                overflow: hidden;
                min-height: 110px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .split-stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            /* Left Content */
            .split-card-content {
                position: relative;
                z-index: 2;
                flex: 1;
            }

            .split-card-title {
                font-size: 13px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0 0 8px 0;
                opacity: 0.95;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            .split-card-number {
                font-size: 28px;
                font-weight: 700;
                margin: 0;
                line-height: 1;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            /* Right Curved Shape */
            .split-card-icon {
                position: absolute;
                right: 0;
                top: 0;
                height: 100%;
                width: 35%;
                /* Adjusts how wide the curve section is */
                background-color: var(--shape-color);
                border-top-left-radius: 120px;
                /* Creates the curve */
                border-bottom-left-radius: 120px;
                /* Creates the curve */
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 32px;
                z-index: 1;
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Optional hover effect on the shape */
            .split-stat-card:hover .split-card-icon {
                width: 38%;
            }

            /* --- 8 Unique Color Themes --- */

            /* 1. Base Brand Color */
            .theme-brand-base {
                background: linear-gradient(120deg, #ba511d 0%, #d4724a 100%);
                --shape-color: #8a3a12;
            }

            /* 2. Soft Blush Copper */
            .theme-brand-copper {
                background: linear-gradient(120deg, #c96340 0%, #dea080 100%);
                --shape-color: #9a4228;
            }

            /* 3. Warm Peach Clay */
            .theme-brand-clay {
                background: linear-gradient(120deg, #d4845a 0%, #e8b595 100%);
                --shape-color: #ba511d;
            }

            /* 4. Dusty Rose Sienna */
            .theme-brand-sienna {
                background: linear-gradient(120deg, #c05535 0%, #d98870 100%);
                --shape-color: #8f3820;
            }

            /* 5. Soft Amber Gold */
            .theme-brand-gold {
                background: linear-gradient(120deg, #c97a2a 0%, #e0aa6a 100%);
                --shape-color: #9a5518;
            }

            /* 6. Linen Sand */
            .theme-brand-sand {
                background: linear-gradient(120deg, #d4a07a 0%, #e8c9aa 100%);
                --shape-color: #b07045;
            }

            /* 7. Soft Brick */
            .theme-brand-brick {
                background: linear-gradient(120deg, #b84535 0%, #d08070 100%);
                --shape-color: #8a2e20;
            }

            /* 8. Warm Mist Mahogany */
            .theme-brand-mahogany {
                background: linear-gradient(120deg, #9a4020 0%, #c07a5a 100%);
                --shape-color: #6e2a12;
            }
        </style>
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.getElementById('productFiltersForm');
                if (!filterForm) {
                    return;
                }

                filterForm.querySelectorAll('select').forEach(function(select) {
                    select.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });

                filterForm.querySelector('input[name="search"]').addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        filterForm.submit();
                    }
                });
            });
        </script>
    @endpush

    {{ $products->links() }}
@endsection
