@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('Products'))
@section('header_title', d_trans('Products'))
@section('content')

    {{-- Action Bar --}}
    <div class="d-flex justify-content-end gap-2 mb-4">
        <div id="bulkDeleteToolbar" class="d-none">
            <button type="button" id="bulkDeleteBtn" class="prod-btn-danger">
                <i class="fa-solid fa-trash me-1"></i>
                <span id="bulkDeleteCount">0</span> {{ d_trans('Selected') }} &mdash; {{ d_trans('Delete') }}
            </button>
        </div>
        <a href="{{ route('admin.products.create') }}" class="prod-btn-primary">
            <i class="fa-solid fa-plus me-1"></i>{{ d_trans('Add Product') }}
        </a>
    </div>

    {{-- Hidden bulk delete form --}}
    <form id="bulkDeleteForm" action="{{ route('admin.products.bulk-destroy') }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="prod-stat-card">
                <div class="prod-stat-icon prod-icon-green">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="prod-stat-body">
                    <div class="prod-stat-number">{{ $counters['active'] }}</div>
                    <div class="prod-stat-label">{{ d_trans('Active') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="prod-stat-card">
                <div class="prod-stat-icon prod-icon-red">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div class="prod-stat-body">
                    <div class="prod-stat-number">{{ $counters['inactive'] }}</div>
                    <div class="prod-stat-label">{{ d_trans('Inactive') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="prod-stat-card">
                <div class="prod-stat-icon prod-icon-violet">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <div class="prod-stat-body">
                    <div class="prod-stat-number">{{ $counters['featured'] }}</div>
                    <div class="prod-stat-label">{{ d_trans('Featured') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="prod-stat-card">
                <div class="prod-stat-icon prod-icon-teal">
                    <i class="fa-solid fa-flask-vial"></i>
                </div>
                <div class="prod-stat-body">
                    <div class="prod-stat-number">{{ $counters['lab_verified'] }}</div>
                    <div class="prod-stat-label">{{ d_trans('Lab Verified') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="prod-card">

        {{-- Filter Header --}}
        <div class="prod-card-header">
            <form action="{{ url()->current() }}" method="GET" id="productFiltersForm">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-lg-4">
                        <div class="prod-search-wrap">
                            <i class="fa fa-search prod-search-icon"></i>
                            <input type="text" name="search" class="prod-search-input"
                                placeholder="{{ d_trans('Search products...') }}" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <select name="category" class="prod-select select2" data-placeholder="{{ d_trans('Category') }}">
                            <option value="">{{ d_trans('Category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == "$category->id")>
                                    {{ $category->trans->name ?? $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <select name="sub_category" class="prod-select select2"
                            data-placeholder="{{ d_trans('Sub Category') }}">
                            <option value="">{{ d_trans('Sub Category') }}</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @selected(request('sub_category') == "$subCategory->id")>
                                    {{ $subCategory->trans->name ?? $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <select name="status" class="prod-select">
                            <option value="">{{ d_trans('All Status') }}</option>
                            <option value="1" @selected(request('status') === '1')>{{ d_trans('Active') }}</option>
                            <option value="0" @selected(request('status') === '0')>{{ d_trans('Inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="prod-btn-primary flex-fill">
                                <i class="fa fa-search me-1"></i>{{ d_trans('Filter') }}
                            </button>
                            <a href="{{ url()->current() }}" class="prod-btn-ghost">{{ d_trans('Reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th style="width:40px">
                            <input type="checkbox" id="selectAll" class="prod-checkbox" title="Select All">
                        </th>
                        <th>#</th>
                        <th class="text-center">{{ d_trans('Image') }}</th>
                        <th>{{ d_trans('Name') }}</th>
                        <th class="text-center">{{ d_trans('Brand') }}</th>
                        <th class="text-center">{{ d_trans('Category') }}</th>
                        <th class="text-center">{{ d_trans('Sub Category') }}</th>
                        <th class="text-center">{{ d_trans('Grade') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Added') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" class="prod-checkbox product-checkbox" value="{{ $product->id }}">
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $product->id) }}" class="prod-id-link">
                                    #{{ $product->id }}
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.show', $product->id) }}">
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            class="prod-thumb">
                                    @else
                                        <div class="prod-thumb-placeholder">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $product->id) }}" class="prod-name-link">
                                    {{ $product->name }}
                                </a>
                                <span class="prod-slug">{{ $product->slug }}</span>
                            </td>
                            <td class="text-center prod-meta">{{ $product->brand->name ?? '-' }}</td>
                            <td class="text-center prod-meta">{{ $product->category->trans->name ?? '-' }}</td>
                            <td class="text-center prod-meta">{{ $product->subCategory->trans->name ?? '-' }}</td>
                            <td class="text-center">
                                @if ($product->overall_grade)
                                    <span class="prod-badge prod-badge-grade">
                                        {{ str_replace('_', ' ', ucfirst($product->overall_grade)) }}
                                    </span>
                                @else
                                    <span class="prod-meta">--</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($product->is_active)
                                    <span class="prod-badge prod-badge-active">{{ d_trans('Active') }}</span>
                                @else
                                    <span class="prod-badge prod-badge-inactive">{{ d_trans('Inactive') }}</span>
                                @endif
                            </td>
                            <td class="text-center prod-meta">{{ dateFormat($product->created_at) }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="prod-action-btn" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.products.show', $product->id) }}">
                                                <i class="fas fa-desktop me-2"></i>{{ d_trans('View Details') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.products.edit', $product->id) }}">
                                                <i class="fas fa-pen me-2"></i>{{ d_trans('Edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.products.lab-tests', $product->id) }}">
                                                <i class="fa-solid fa-flask-vial me-2"></i>{{ d_trans('Lab Test') }}
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
                                                    <i class="far fa-trash-alt me-2"></i>{{ d_trans('Delete') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        @include('admin.partials.empty-table', ['colspan' => 11])
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="prod-pagination">
            {{ $products->links() }}
        </div>
    </div>

    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link href="{{ asset('vendor/admin/css/select2.min.css') }}" rel="stylesheet" />
    @endpush

    @push('styles')
        <style>
            :root {
                --prod-red: #dc2626;
                --prod-red-dark: #b91c1c;
                --prod-red-soft: rgba(220, 38, 38, 0.08);
                --prod-bg: rgb(249, 250, 251);
                --prod-border: rgba(0, 0, 0, 0.08);
                --prod-text: #1e293b;
                --prod-muted: #64748b;
            }

            /* Buttons */
            .prod-btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: var(--prod-red);
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                text-decoration: none;
                transition: background 0.18s;
                white-space: nowrap;
            }

            .prod-btn-primary:hover {
                background: var(--prod-red-dark);
                color: #fff;
            }

            .prod-btn-danger {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: #fee2e2;
                color: var(--prod-red);
                border: 1px solid #fca5a5;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.18s;
            }

            .prod-btn-danger:hover {
                background: #fecaca;
            }

            .prod-btn-ghost {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 9px 16px;
                background: transparent;
                color: var(--prod-muted);
                border: 1px solid var(--prod-border);
                border-radius: 8px;
                font-size: 0.875rem;
                cursor: pointer;
                text-decoration: none;
                transition: background 0.18s, color 0.18s;
                white-space: nowrap;
            }

            .prod-btn-ghost:hover {
                background: var(--prod-red-soft);
                color: var(--prod-red);
            }

            /* Stat Cards */
            .prod-stat-card {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 12px;
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
                transition: box-shadow 0.2s, transform 0.2s;
            }

            .prod-stat-card:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
                transform: translateY(-2px);
            }

            .prod-stat-icon {
                width: 48px;
                height: 48px;
                min-width: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }

            .prod-icon-green {
                background: rgba(22, 163, 74, 0.12);
                color: #15803d;
            }

            .prod-icon-red {
                background: rgba(220, 38, 38, 0.12);
                color: #dc2626;
            }

            .prod-icon-violet {
                background: rgba(139, 92, 246, 0.12);
                color: #7c3aed;
            }

            .prod-icon-teal {
                background: rgba(20, 184, 166, 0.12);
                color: #0d9488;
            }

            .prod-stat-number {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--prod-text);
                line-height: 1;
            }

            .prod-stat-label {
                font-size: 0.7rem;
                font-weight: 700;
                color: rgba(220, 38, 38, 0.55);
                text-transform: uppercase;
                letter-spacing: 0.6px;
                margin-top: 4px;
            }

            /* Main Card */
            .prod-card {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            }

            .prod-card-header {
                padding: 20px 24px;
                border-bottom: 1px solid var(--prod-border);
                background: var(--prod-bg);
            }

            /* Search & Filters */
            .prod-search-wrap {
                position: relative;
            }

            .prod-search-icon {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--prod-muted);
                font-size: 0.8rem;
                pointer-events: none;
            }

            .prod-search-input {
                width: 100%;
                padding: 9px 14px 9px 38px;
                border: 1px solid var(--prod-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--prod-text);
                transition: border-color 0.18s, box-shadow 0.18s;
                outline: none;
            }

            .prod-search-input:focus {
                border-color: var(--prod-red);
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }

            .prod-select {
                width: 100%;
                padding: 9px 14px;
                border: 1px solid var(--prod-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--prod-text);
                outline: none;
                cursor: pointer;
                transition: border-color 0.18s;
                -webkit-appearance: auto;
            }

            .prod-select:focus {
                border-color: var(--prod-red);
            }

            /* Select2 */
            .select2-container {
                width: 100% !important;
            }

            .select2-container--default .select2-selection--single {
                height: 38px !important;
                border: 1px solid var(--prod-border) !important;
                border-radius: 8px !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px !important;
                padding-left: 14px !important;
                color: var(--prod-text) !important;
                font-size: 0.875rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px !important;
            }

            .select2-container--default.select2-container--focus .select2-selection--single,
            .select2-container--default.select2-container--open .select2-selection--single {
                border-color: var(--prod-red) !important;
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
            }

            /* Table */
            .prod-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.875rem;
            }

            .prod-table thead th {
                padding: 11px 16px;
                font-size: 0.68rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                /* color: rgba(220, 38, 38, 0.6); */
                border-bottom: 1px solid var(--prod-border);
                white-space: nowrap;
                background: var(--prod-bg);
            }

            .prod-table tbody tr {
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                transition: background 0.15s;
            }

            .prod-table tbody tr:hover {
                background: rgba(220, 38, 38, 0.025);
            }

            .prod-table tbody tr:last-child {
                border-bottom: none;
            }

            .prod-table td {
                padding: 12px 16px;
                color: var(--prod-text);
                vertical-align: middle;
            }

            /* Checkbox */
            .prod-checkbox {
                width: 16px;
                height: 16px;
                accent-color: var(--prod-red);
                cursor: pointer;
            }

            /* Table elements */
            .prod-id-link {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--prod-red);
                text-decoration: none;
            }

            .prod-id-link:hover {
                color: var(--prod-red-dark);
            }

            .prod-thumb {
                width: 42px;
                height: 42px;
                object-fit: cover;
                border-radius: 8px;
                border: 1px solid var(--prod-border);
            }

            .prod-thumb-placeholder {
                width: 42px;
                height: 42px;
                border-radius: 8px;
                border: 1px solid var(--prod-border);
                background: var(--prod-bg);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: var(--prod-muted);
                font-size: 1rem;
            }

            .prod-name-link {
                display: block;
                font-weight: 500;
                color: var(--prod-text);
                text-decoration: none;
                line-height: 1.4;
            }

            .prod-name-link:hover {
                color: var(--prod-red);
            }

            .prod-slug {
                display: block;
                font-size: 0.74rem;
                color: var(--prod-muted);
                margin-top: 2px;
            }

            .prod-meta {
                color: var(--prod-muted);
                font-size: 0.85rem;
            }

            /* Badges */
            .prod-badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 10px;
                border-radius: 20px;
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            .prod-badge-active {
                background: rgba(22, 163, 74, 0.1);
                color: #15803d;
            }

            .prod-badge-inactive {
                background: rgba(220, 38, 38, 0.1);
                color: #dc2626;
            }

            .prod-badge-grade {
                background: rgba(220, 38, 38, 0.08);
                color: #b91c1c;
                border: 1px solid rgba(220, 38, 38, 0.2);
            }

            /* Action Button */
            .prod-action-btn {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                border: 1px solid var(--prod-border);
                background: transparent;
                color: var(--prod-muted);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background 0.18s, color 0.18s;
            }

            .prod-action-btn:hover {
                background: var(--prod-red-soft);
                color: var(--prod-red);
                border-color: rgba(220, 38, 38, 0.2);
            }

            /* Pagination */
            .prod-pagination {
                padding: 16px 24px;
                border-top: 1px solid var(--prod-border);
            }
        </style>
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/admin/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%'
                }).on('change', function() {
                    $('#productFiltersForm').submit();
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.getElementById('productFiltersForm');
                if (!filterForm) return;
                filterForm.querySelectorAll('select:not(.select2)').forEach(function(select) {
                    select.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });
                const searchInput = filterForm.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            filterForm.submit();
                        }
                    });
                }
            });
        </script>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAll = document.getElementById('selectAll');
                const toolbar = document.getElementById('bulkDeleteToolbar');
                const countBadge = document.getElementById('bulkDeleteCount');
                const bulkBtn = document.getElementById('bulkDeleteBtn');
                const bulkForm = document.getElementById('bulkDeleteForm');

                function getChecked() {
                    return Array.from(document.querySelectorAll('.product-checkbox:checked'));
                }

                function updateToolbar() {
                    const checked = getChecked();
                    toolbar.classList.toggle('d-none', checked.length === 0);
                    countBadge.textContent = checked.length;
                    if (selectAll) {
                        const all = document.querySelectorAll('.product-checkbox');
                        selectAll.checked = all.length > 0 && checked.length === all.length;
                        selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
                    }
                }
                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        document.querySelectorAll('.product-checkbox').forEach(function(cb) {
                            cb.checked = selectAll.checked;
                        });
                        updateToolbar();
                    });
                }
                document.querySelectorAll('.product-checkbox').forEach(function(cb) {
                    cb.addEventListener('change', updateToolbar);
                });
                if (bulkBtn) {
                    bulkBtn.addEventListener('click', function() {
                        const checked = getChecked();
                        if (!checked.length) return;
                        if (!confirm(
                                '{{ d_trans('Are you sure you want to delete the selected products? This action cannot be undone.') }}'
                                )) return;
                        bulkForm.querySelectorAll('input[name="ids[]"]').forEach(function(el) {
                            el.remove();
                        });
                        checked.forEach(function(cb) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = cb.value;
                            bulkForm.appendChild(input);
                        });
                        bulkForm.submit();
                    });
                }
            });
        </script>
    @endpush

@endsection
