@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('Ingredient Library'))
@section('header_title', d_trans('Ingredient Library'))
@section('content')

    {{-- Action Bar --}}
    <div class="d-flex justify-content-end gap-2 mb-4">
        <div id="bulkDeleteToolbar" class="d-none">
            <button type="button" id="bulkDeleteBtn" class="ing-btn-danger">
                <i class="fa-solid fa-trash me-1"></i>
                <span id="bulkDeleteCount">0</span> {{ d_trans('Selected') }} &mdash; {{ d_trans('Delete') }}
            </button>
        </div>
        <a href="{{ route('admin.ingredients-library.create') }}" class="ing-btn-primary">
            <i class="fa-solid fa-plus me-1"></i>{{ d_trans('Add Ingredient') }}
        </a>
    </div>

    {{-- Hidden bulk delete form --}}
    <form id="bulkDeleteForm" action="{{ route('admin.ingredients-library.index') }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="ing-stat-card">
                <div class="ing-stat-icon ing-icon-blue">
                    <i class="fa-solid fa-flask"></i>
                </div>
                <div class="ing-stat-body">
                    <div class="ing-stat-number">{{ $counters['total'] }}</div>
                    <div class="ing-stat-label">{{ d_trans('Total') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="ing-stat-card">
                <div class="ing-stat-icon ing-icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="ing-stat-body">
                    <div class="ing-stat-number">{{ $counters['published'] }}</div>
                    <div class="ing-stat-label">{{ d_trans('Published') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="ing-stat-card">
                <div class="ing-stat-icon ing-icon-red">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div class="ing-stat-body">
                    <div class="ing-stat-number">{{ $counters['avoid'] }}</div>
                    <div class="ing-stat-label">{{ d_trans('Avoid') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="ing-stat-card">
                <div class="ing-stat-icon ing-icon-orange">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="ing-stat-body">
                    <div class="ing-stat-number">{{ $counters['concern'] }}</div>
                    <div class="ing-stat-label">{{ d_trans('Concern') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="ing-card">

        {{-- Filter Header --}}
        <div class="ing-card-header">
            <form action="{{ url()->current() }}" method="GET" id="ingredientFiltersForm">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-lg-5">
                        <div class="ing-search-wrap">
                            <i class="fa fa-search ing-search-icon"></i>
                            <input type="text" name="search" class="ing-search-input"
                                placeholder="{{ d_trans('Search by name, INCI, CAS, description...') }}"
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <select name="severity" class="ing-select">
                            <option value="">{{ d_trans('All Severity') }}</option>
                            <option value="none"     @selected(request('severity') === 'none')>{{ d_trans('None') }}</option>
                            <option value="caution"  @selected(request('severity') === 'caution')>{{ d_trans('Caution') }}</option>
                            <option value="concern"  @selected(request('severity') === 'concern')>{{ d_trans('Concern') }}</option>
                            <option value="avoid"    @selected(request('severity') === 'avoid')>{{ d_trans('Avoid') }}</option>
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <select name="status" class="ing-select">
                            <option value="">{{ d_trans('All Status') }}</option>
                            <option value="1" @selected(request('status') === '1')>{{ d_trans('Published') }}</option>
                            <option value="0" @selected(request('status') === '0')>{{ d_trans('Draft') }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="ing-btn-primary flex-fill justify-content-center">
                                <i class="fa fa-search me-1"></i>{{ d_trans('Filter') }}
                            </button>
                            <a href="{{ url()->current() }}" class="ing-btn-ghost">{{ d_trans('Reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="ing-table">
                <thead>
                    <tr>
                        <th style="width:40px">
                            <input type="checkbox" id="selectAll" class="ing-checkbox" title="{{ d_trans('Select All') }}">
                        </th>
                        <th>#</th>
                        <th>{{ d_trans('Name') }}</th>
                        <th>{{ d_trans('INCI Name') }}</th>
                        <th class="text-center">{{ d_trans('CAS Number') }}</th>
                        <th class="text-center">{{ d_trans('Severity') }}</th>
                        <th class="text-center">{{ d_trans('Found In') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Added') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ingredients as $ingredient)
                        <tr>
                            <td>
                                <input type="checkbox" class="ing-checkbox ingredient-checkbox" value="{{ $ingredient->id }}">
                            </td>
                            <td>
                                <a href="{{ route('admin.ingredients-library.show', $ingredient->id) }}" class="ing-id-link">
                                    #{{ $ingredient->id }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.ingredients-library.show', $ingredient->id) }}" class="ing-name-link">
                                    {{ $ingredient->name }}
                                </a>
                                @if ($ingredient->slug)
                                    <span class="ing-slug">{{ $ingredient->slug }}</span>
                                @endif
                            </td>
                            <td class="ing-meta">{{ $ingredient->inci_name ?? '--' }}</td>
                            <td class="text-center ing-meta">{{ $ingredient->cas_number ?? '--' }}</td>
                            <td class="text-center">
                                @if ($ingredient->severity && $ingredient->severity !== 'none')
                                    @php
                                        $severityClass = match($ingredient->severity) {
                                            'avoid'   => 'ing-badge-avoid',
                                            'concern' => 'ing-badge-concern',
                                            'caution' => 'ing-badge-caution',
                                            default   => 'ing-badge-none',
                                        };
                                    @endphp
                                    <span class="ing-badge {{ $severityClass }}">
                                        {{ d_trans(ucfirst($ingredient->severity)) }}
                                    </span>
                                @else
                                    <span class="ing-meta">--</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="ing-badge ing-badge-count">{{ $ingredient->found_in_count ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                @if ($ingredient->is_published)
                                    <span class="ing-badge ing-badge-published">{{ d_trans('Published') }}</span>
                                @else
                                    <span class="ing-badge ing-badge-draft">{{ d_trans('Draft') }}</span>
                                @endif
                            </td>
                            <td class="text-center ing-meta">{{ dateFormat($ingredient->created_at) }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="ing-action-btn" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end ing-dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.ingredients-library.show', $ingredient->id) }}">
                                                <i class="fas fa-eye"></i>{{ d_trans('View Details') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.ingredients-library.edit', $ingredient->id) }}">
                                                <i class="fas fa-pen"></i>{{ d_trans('Edit') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider" /></li>
                                        <li>
                                            <form action="{{ route('admin.ingredients-library.destroy', $ingredient->id) }}"
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
                        @include('admin.partials.empty-table', ['colspan' => 10])
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="ing-pagination">
            {{ $ingredients->links() }}
        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --ing-red: #dc2626;
                --ing-red-dark: #b91c1c;
                --ing-red-soft: rgba(220, 38, 38, 0.08);
                --ing-bg: rgb(249, 250, 251);
                --ing-border: rgba(0, 0, 0, 0.08);
                --ing-text: #1e293b;
                --ing-muted: #64748b;
            }

            /* Buttons */
            .ing-btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: var(--ing-red);
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
            .ing-btn-primary:hover { background: var(--ing-red-dark); color: #fff; }

            .ing-btn-danger {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: #fee2e2;
                color: var(--ing-red);
                border: 1px solid #fca5a5;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.18s;
            }
            .ing-btn-danger:hover { background: #fecaca; }

            .ing-btn-ghost {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 9px 16px;
                background: transparent;
                color: var(--ing-muted);
                border: 1px solid var(--ing-border);
                border-radius: 8px;
                font-size: 0.875rem;
                cursor: pointer;
                text-decoration: none;
                transition: background 0.18s, color 0.18s;
                white-space: nowrap;
            }
            .ing-btn-ghost:hover { background: var(--ing-red-soft); color: var(--ing-red); }

            /* Stat Cards */
            .ing-stat-card {
                background: #fff;
                border: 1px solid var(--ing-border);
                border-radius: 12px;
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                transition: box-shadow 0.2s, transform 0.2s;
            }
            .ing-stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-2px); }

            .ing-stat-icon {
                width: 48px; height: 48px; min-width: 48px;
                border-radius: 12px;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.1rem;
            }
            .ing-icon-blue   { background: rgba(37,99,235,0.12);  color: #2563eb; }
            .ing-icon-green  { background: rgba(22,163,74,0.12);  color: #15803d; }
            .ing-icon-red    { background: rgba(220,38,38,0.12);  color: #dc2626; }
            .ing-icon-orange { background: rgba(234,88,12,0.12);  color: #ea580c; }

            .ing-stat-number { font-size: 1.75rem; font-weight: 700; color: var(--ing-text); line-height: 1; }
            .ing-stat-label  { font-size: 0.7rem; font-weight: 700; color: rgba(220,38,38,0.55); text-transform: uppercase; letter-spacing: 0.6px; margin-top: 4px; }

            /* Main Card */
            .ing-card {
                background: #fff;
                border: 1px solid var(--ing-border);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }
            .ing-card-header {
                padding: 20px 24px;
                border-bottom: 1px solid var(--ing-border);
                background: var(--ing-bg);
            }

            /* Search */
            .ing-search-wrap { position: relative; }
            .ing-search-icon {
                position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
                color: var(--ing-muted); font-size: 0.8rem; pointer-events: none;
            }
            .ing-search-input {
                width: 100%;
                padding: 9px 14px 9px 38px;
                border: 1px solid var(--ing-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--ing-text);
                transition: border-color 0.18s, box-shadow 0.18s;
                outline: none;
            }
            .ing-search-input:focus { border-color: var(--ing-red); box-shadow: 0 0 0 3px rgba(220,38,38,0.1); }

            .ing-select {
                width: 100%;
                padding: 9px 14px;
                border: 1px solid var(--ing-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--ing-text);
                outline: none;
                cursor: pointer;
                transition: border-color 0.18s;
                -webkit-appearance: auto;
            }
            .ing-select:focus { border-color: var(--ing-red); }

            /* Table */
            .ing-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
            .ing-table thead th {
                padding: 11px 16px;
                font-size: 0.68rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #64748b;
                border-bottom: 1px solid var(--ing-border);
                white-space: nowrap;
                background: var(--ing-bg);
            }
            .ing-table tbody tr { border-bottom: 1px solid rgba(0,0,0,0.04); transition: background 0.15s; background: #fff; }
            .ing-table tbody tr:hover { background: linear-gradient(90deg, rgba(220,38,38,0.035), #fff); }
            .ing-table tbody tr:last-child { border-bottom: none; }
            .ing-table td { padding: 12px 16px; color: var(--ing-text); vertical-align: middle; }

            /* Checkbox */
            .ing-checkbox { width: 16px; height: 16px; accent-color: var(--ing-red); cursor: pointer; }

            /* Table elements */
            .ing-id-link { font-size: 0.8rem; font-weight: 600; color: var(--ing-red); text-decoration: none; }
            .ing-id-link:hover { color: var(--ing-red-dark); }

            .ing-name-link { display: block; font-weight: 500; color: var(--ing-text); text-decoration: none; line-height: 1.4; }
            .ing-name-link:hover { color: var(--ing-red); }

            .ing-slug { display: block; font-size: 0.74rem; color: var(--ing-muted); margin-top: 2px; }
            .ing-meta { color: var(--ing-muted); font-size: 0.85rem; }

            /* Badges */
            .ing-badge {
                display: inline-flex; align-items: center;
                padding: 3px 10px; border-radius: 20px;
                font-size: 0.7rem; font-weight: 600; letter-spacing: 0.3px;
            }
            .ing-badge-published { background: rgba(22,163,74,0.1);  color: #15803d; }
            .ing-badge-draft     { background: rgba(100,116,139,0.1); color: #64748b; }
            .ing-badge-avoid     { background: rgba(220,38,38,0.1);   color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
            .ing-badge-concern   { background: rgba(234,88,12,0.1);   color: #ea580c; border: 1px solid rgba(234,88,12,0.2); }
            .ing-badge-caution   { background: rgba(202,138,4,0.1);   color: #a16207; border: 1px solid rgba(202,138,4,0.2); }
            .ing-badge-none      { background: rgba(100,116,139,0.1); color: #64748b; }
            .ing-badge-count     { background: rgba(37,99,235,0.08);  color: #2563eb; border: 1px solid rgba(37,99,235,0.15); }

            /* Action Button */
            .ing-action-btn {
                width: 32px; height: 32px; border-radius: 8px;
                border: 1px solid var(--ing-border);
                background: transparent; color: var(--ing-muted);
                display: inline-flex; align-items: center; justify-content: center;
                cursor: pointer; transition: background 0.18s, color 0.18s;
            }
            .ing-action-btn:hover { background: var(--ing-red-soft); color: var(--ing-red); border-color: rgba(220,38,38,0.2); }

            /* Dropdown */
            .ing-dropdown-menu {
                padding: 8px;
                border: 1px solid rgba(15,23,42,0.10);
                border-radius: 16px;
                box-shadow: 0 18px 42px rgba(15,23,42,0.14);
            }
            .ing-dropdown-menu .dropdown-item {
                display: flex; align-items: center; gap: 10px;
                min-height: 38px; padding: 8px 11px; border-radius: 11px;
                color: var(--ing-text); font-size: 0.86rem; font-weight: 700;
                transition: all 0.18s ease;
            }
            .ing-dropdown-menu .dropdown-item i { width: 18px; color: var(--ing-muted); }
            .ing-dropdown-menu .dropdown-item:hover { background: var(--ing-red-soft); color: var(--ing-red); }
            .ing-dropdown-menu .dropdown-item:hover i { color: var(--ing-red); }
            .ing-dropdown-menu .dropdown-divider { margin: 7px 4px; }
            .ing-dropdown-menu .dropdown-item.text-danger { color: #dc2626 !important; }
            .ing-dropdown-menu .dropdown-item.text-danger:hover { background: rgba(220,38,38,0.10); }

            /* Pagination */
            .ing-pagination { padding: 16px 24px; border-top: 1px solid var(--ing-border); }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const filterForm = document.getElementById('ingredientFiltersForm');
                if (filterForm) {
                    filterForm.querySelectorAll('select').forEach(function (select) {
                        select.addEventListener('change', function () { filterForm.submit(); });
                    });
                    const searchInput = filterForm.querySelector('input[name="search"]');
                    if (searchInput) {
                        searchInput.addEventListener('keydown', function (e) {
                            if (e.key === 'Enter') { e.preventDefault(); filterForm.submit(); }
                        });
                    }
                }

                const selectAll  = document.getElementById('selectAll');
                const toolbar    = document.getElementById('bulkDeleteToolbar');
                const countBadge = document.getElementById('bulkDeleteCount');
                const bulkBtn    = document.getElementById('bulkDeleteBtn');

                function getChecked() {
                    return Array.from(document.querySelectorAll('.ingredient-checkbox:checked'));
                }
                function updateToolbar() {
                    const checked = getChecked();
                    toolbar.classList.toggle('d-none', checked.length === 0);
                    countBadge.textContent = checked.length;
                    if (selectAll) {
                        const all = document.querySelectorAll('.ingredient-checkbox');
                        selectAll.checked       = all.length > 0 && checked.length === all.length;
                        selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
                    }
                }
                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        document.querySelectorAll('.ingredient-checkbox').forEach(cb => cb.checked = selectAll.checked);
                        updateToolbar();
                    });
                }
                document.querySelectorAll('.ingredient-checkbox').forEach(cb => cb.addEventListener('change', updateToolbar));
            });
        </script>
    @endpush

@endsection
