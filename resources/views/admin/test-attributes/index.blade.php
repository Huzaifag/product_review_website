@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Test Attributes'))
@section('title', d_trans('Test Attributes'))
@section('header_title', d_trans('Test Attributes'))
@section('create', route('admin.test-attributes.create'))
@section('content')
    <div class="ui-card">
        <div class="ui-card-header">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-10">
                        <div class="ui-search-wrap">
                            <i class="fa fa-search ui-search-icon"></i>
                            <input type="text" name="search" class="ui-search-input" placeholder="{{ d_trans('Search...') }}"
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-6 col-lg-1">
                        <button class="ui-btn-primary w-100 justify-content-center">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-6 col-lg-1">
                        <a href="{{ url()->current() }}" class="ui-btn-ghost w-100 justify-content-center">
                            {{ d_trans('Reset') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-0">
            <div class="table-responsive">
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Name') }}</th>
                            <th>{{ d_trans('Type') }}</th>
                            <th>{{ d_trans('Options') }}</th>
                            <th>{{ d_trans('Status') }}</th>
                            <th>{{ d_trans('Date') }}</th>
                            <th>{{ d_trans('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($testAttributes as $testAttribute)
                            <tr>
                                <!-- Index -->
                                <td>{{ $loop->iteration }}</td>

                                <!-- Name -->
                                <td>{{ $testAttribute->name }}</td>

                                <!-- Type -->
                                <td>
                                    @if ($testAttribute->type === 'select')
                                        <span class="ui-badge" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">{{ d_trans('Select') }}</span>
                                    @else
                                        <span class="ui-badge" style="background: rgba(100, 116, 139, 0.1); color: #64748b;">{{ d_trans('Text') }}</span>
                                    @endif
                                </td>

                                <!-- Options -->
                                <td style="max-width: 200px;">
                                    @if ($testAttribute->type === 'select' && !empty($testAttribute->options))
                                        @php
                                            $options = is_array($testAttribute->options)
                                                ? $testAttribute->options
                                                : json_decode($testAttribute->options, true);
                                        @endphp

                                        @if (!empty($options))
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($options as $option)
                                                    <span class="ui-badge" style="background: rgba(6, 182, 212, 0.1); color: #0891b2;">{{ $option }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td>
                                    @if ($testAttribute->active())
                                        <span class="ui-badge ui-badge-active">{{ d_trans('Active') }}</span>
                                    @else
                                        <span class="ui-badge ui-badge-inactive">{{ d_trans('Inactive') }}</span>
                                    @endif
                                </td>

                                <!-- Date -->
                                <td>{{ $testAttribute->created_at?->format('d M Y') }}</td>

                                <!-- Actions -->
                                <td>
                                    <div class="dropdown">
                                        <button class="ui-action-btn dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $testAttribute->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>

                                        <ul class="dropdown-menu ui-dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $testAttribute->id }}">

                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.test-attributes.edit', $testAttribute->id) }}">
                                                    <i class="fa fa-edit"></i> {{ d_trans('Edit') }}
                                                </a>
                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>
                                                <a class="dropdown-item text-danger"
                                                    href="{{ route('admin.test-attributes.destroy', $testAttribute->id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $testAttribute->id }}').submit();">
                                                    <i class="fa fa-trash"></i> {{ d_trans('Delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Delete Form -->
                                    <form id="delete-form-{{ $testAttribute->id }}"
                                        action="{{ route('admin.test-attributes.destroy', $testAttribute->id) }}"
                                        method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 7])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ui-pagination">
            {{ $testAttributes->links() }}
        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --ui-primary: #dc2626;
                --ui-primary-dark: #b91c1c;
                --ui-primary-soft: rgba(220, 38, 38, 0.08);
                --ui-bg: rgb(249, 250, 251);
                --ui-border: rgba(0, 0, 0, 0.08);
                --ui-text: #1e293b;
                --ui-muted: #64748b;
            }

            /* Buttons */
            .ui-btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: var(--ui-primary);
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

            .ui-btn-primary:hover {
                background: var(--ui-primary-dark);
                color: #fff;
            }

            .ui-btn-danger {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: #fee2e2;
                color: var(--ui-primary);
                border: 1px solid #fca5a5;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.18s;
            }

            .ui-btn-danger:hover {
                background: #fecaca;
            }

            .ui-btn-ghost {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 9px 16px;
                background: transparent;
                color: var(--ui-muted);
                border: 1px solid var(--ui-border);
                border-radius: 8px;
                font-size: 0.875rem;
                cursor: pointer;
                text-decoration: none;
                transition: background 0.18s, color 0.18s;
                white-space: nowrap;
            }

            .ui-btn-ghost:hover {
                background: var(--ui-primary-soft);
                color: var(--ui-primary);
            }

            /* Stat Cards */
            .ui-stat-card {
                background: #fff;
                border: 1px solid var(--ui-border);
                border-radius: 12px;
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
                transition: box-shadow 0.2s, transform 0.2s;
            }

            .ui-stat-card:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
                transform: translateY(-2px);
            }

            .ui-stat-icon {
                width: 48px;
                height: 48px;
                min-width: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }

            .ui-icon-green {
                background: rgba(22, 163, 74, 0.12);
                color: #15803d;
            }

            .ui-icon-red {
                background: rgba(220, 38, 38, 0.12);
                color: #dc2626;
            }

            .ui-icon-violet {
                background: rgba(139, 92, 246, 0.12);
                color: #7c3aed;
            }

            .ui-icon-teal {
                background: rgba(20, 184, 166, 0.12);
                color: #0d9488;
            }

            .ui-stat-number {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--ui-text);
                line-height: 1;
            }

            .ui-stat-label {
                font-size: 0.7rem;
                font-weight: 700;
                color: rgba(220, 38, 38, 0.55);
                text-transform: uppercase;
                letter-spacing: 0.6px;
                margin-top: 4px;
            }

            /* Main Card */
            .ui-card {
                background: #fff;
                border: 1px solid var(--ui-border);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            }

            .ui-card-header {
                padding: 20px 24px;
                border-bottom: 1px solid var(--ui-border);
                background: var(--ui-bg);
            }

            /* Search & Filters */
            .ui-search-wrap {
                position: relative;
            }

            .ui-search-icon {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--ui-muted);
                font-size: 0.8rem;
                pointer-events: none;
            }

            .ui-search-input {
                width: 100%;
                padding: 9px 14px 9px 38px;
                border: 1px solid var(--ui-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--ui-text);
                transition: border-color 0.18s, box-shadow 0.18s;
                outline: none;
            }

            .ui-search-input:focus {
                border-color: var(--ui-primary);
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }

            .ui-select {
                width: 100%;
                padding: 9px 14px;
                border: 1px solid var(--ui-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--ui-text);
                outline: none;
                cursor: pointer;
                transition: border-color 0.18s;
                -webkit-appearance: auto;
            }

            .ui-select:focus {
                border-color: var(--ui-primary);
            }

            /* Select2 */
            .select2-container {
                width: 100% !important;
            }

            .select2-container--default .select2-selection--single {
                height: 38px !important;
                border: 1px solid var(--ui-border) !important;
                border-radius: 8px !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px !important;
                padding-left: 14px !important;
                color: var(--ui-text) !important;
                font-size: 0.875rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px !important;
            }

            .select2-container--default.select2-container--focus .select2-selection--single,
            .select2-container--default.select2-container--open .select2-selection--single {
                border-color: var(--ui-primary) !important;
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
            }

            /* Table */
            .ui-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.875rem;
            }

            .ui-table thead th {
                padding: 11px 16px;
                font-size: 0.68rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                border-bottom: 1px solid var(--ui-border);
                white-space: nowrap;
                background: var(--ui-bg);
            }

            .ui-table tbody tr {
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                transition: background 0.15s;
            }

            .ui-table tbody tr:hover {
                background: rgba(220, 38, 38, 0.025);
            }

            .ui-table tbody tr:last-child {
                border-bottom: none;
            }

            .ui-table td {
                padding: 12px 16px;
                color: var(--ui-text);
                vertical-align: middle;
            }

            /* Checkbox */
            .ui-checkbox {
                width: 16px;
                height: 16px;
                accent-color: var(--ui-primary);
                cursor: pointer;
            }

            /* Table elements */
            .ui-id-link {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--ui-primary);
                text-decoration: none;
            }

            .ui-id-link:hover {
                color: var(--ui-primary-dark);
            }

            .ui-thumb {
                width: 42px;
                height: 42px;
                object-fit: contain;
                border-radius: 8px;
                border: 1px solid var(--ui-border);
            }

            .ui-thumb-placeholder {
                width: 42px;
                height: 42px;
                border-radius: 8px;
                border: 1px solid var(--ui-border);
                background: var(--ui-bg);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: var(--ui-muted);
                font-size: 1rem;
            }

            .ui-name-link {
                display: block;
                font-weight: 500;
                color: var(--ui-text);
                text-decoration: none;
                line-height: 1.4;
            }

            .ui-name-link:hover {
                color: var(--ui-primary);
            }

            .ui-slug {
                display: block;
                font-size: 0.74rem;
                color: var(--ui-muted);
                margin-top: 2px;
            }

            .ui-meta {
                color: var(--ui-muted);
                font-size: 0.85rem;
            }

            /* Badges */
            .ui-badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 10px;
                border-radius: 20px;
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            .ui-badge-active {
                background: rgba(22, 163, 74, 0.1);
                color: #15803d;
            }

            .ui-badge-inactive {
                background: rgba(220, 38, 38, 0.1);
                color: #dc2626;
            }

            .ui-badge-grade {
                background: rgba(220, 38, 38, 0.08);
                color: #b91c1c;
                border: 1px solid rgba(220, 38, 38, 0.2);
            }

            /* Action Button */
            .ui-action-btn {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                border: 1px solid var(--ui-border);
                background: transparent;
                color: var(--ui-muted);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background 0.18s, color 0.18s;
            }

            .ui-action-btn:hover {
                background: var(--ui-primary-soft);
                color: var(--ui-primary);
                border-color: rgba(220, 38, 38, 0.2);
            }

            /* Pagination */
            .ui-pagination {
                padding: 16px 24px;
                border-top: 1px solid var(--ui-border);
            }

            /* Category table image */
            .ui-table-img {
                width: 48px;
                height: 48px;
                min-width: 48px;
                border-radius: 14px;
                overflow: hidden;
                background: #ffffff;
                border: 1px solid var(--ui-border);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
                transition: all 0.22s ease;
            }

            .ui-table-img:hover {
                transform: translateY(-2px) scale(1.03);
                box-shadow: 0 14px 28px rgba(220, 38, 38, 0.14);
                border-color: rgba(220, 38, 38, 0.24);
            }

            .ui-table-img img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                padding: 6px;
            }

            /* Better table look */
            .ui-table thead th {
                color: #64748b;
            }

            .ui-table tbody tr {
                background: #ffffff;
            }

            .ui-table tbody tr:hover {
                background: linear-gradient(90deg, rgba(220, 38, 38, 0.035), #ffffff);
            }

            /* Dropdown menu premium */
            .ui-dropdown-menu {
                padding: 8px;
                border: 1px solid rgba(15, 23, 42, 0.10);
                border-radius: 16px;
                box-shadow: 0 18px 42px rgba(15, 23, 42, 0.14);
            }

            .ui-dropdown-menu .dropdown-item {
                display: flex;
                align-items: center;
                gap: 10px;
                min-height: 38px;
                padding: 8px 11px;
                border-radius: 11px;
                color: var(--ui-text);
                font-size: 0.86rem;
                font-weight: 700;
                transition: all 0.18s ease;
            }

            .ui-dropdown-menu .dropdown-item i {
                width: 18px;
                color: var(--ui-muted);
            }

            .ui-dropdown-menu .dropdown-item:hover {
                background: var(--ui-primary-soft);
                color: var(--ui-primary);
            }

            .ui-dropdown-menu .dropdown-item:hover i {
                color: var(--ui-primary);
            }

            .ui-dropdown-menu .dropdown-divider {
                margin: 7px 4px;
            }

            .ui-dropdown-menu .dropdown-item.text-danger {
                color: #dc2626 !important;
            }

            .ui-dropdown-menu .dropdown-item.text-danger:hover {
                background: rgba(220, 38, 38, 0.10);
            }

            /* Mobile polish */
            @media (max-width: 575px) {
                .ui-card-header {
                    padding: 16px;
                }

                .ui-table td,
                .ui-table thead th {
                    padding: 12px;
                }

                .ui-table-img {
                    width: 42px;
                    height: 42px;
                    min-width: 42px;
                }
            }
        </style>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
@endsection
