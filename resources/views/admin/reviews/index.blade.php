@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('All Reviews'))
@section('header_title', d_trans('All Reviews'))
@section('content')
    <div class="prod-card">
        <div class="prod-card-header">
            <form action="{{ url()->current() }}" method="GET" id="reviewFiltersForm">
                @if (request('user'))
                    <input type="hidden" name="user" value="{{ request('user') }}">
                @endif

                <div class="row g-3 align-items-end">
                    <div class="col-12 col-lg-5">
                        <div class="prod-search-wrap">
                            <i class="fa fa-search prod-search-icon"></i>
                            <input type="text" name="search" class="prod-search-input"
                                placeholder="{{ d_trans('Search reviews...') }}" value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-6 col-lg-2">
                        <select name="status" class="prod-select">
                            <option value="">{{ d_trans('All Status') }}</option>
                            <option value="approved" @selected(request('status') === 'approved')>{{ d_trans('Approved') }}</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>{{ d_trans('Rejected') }}</option>
                        </select>
                    </div>

                    <div class="col-6 col-lg-2">
                        <select name="rating" class="prod-select">
                            <option value="">{{ d_trans('All Ratings') }}</option>
                            @for ($rating = 5; $rating >= 1; $rating--)
                                <option value="{{ $rating }}" @selected(request('rating') == $rating)>
                                    {{ $rating }} {{ $rating === 1 ? d_trans('Star') : d_trans('Stars') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-12 col-lg-3">
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

        <div class="table-responsive">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ d_trans('Product') }}</th>
                        <th>{{ d_trans('Submitted by') }}</th>
                        <th class="text-center">{{ d_trans('Rating') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Submitted date') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        @php
                            $user = $review->user;
                            $reviewer = $review->reviewer;
                            $product = $review->product;
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="prod-id-link">
                                    #{{ $review->id }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($product)
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
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.products.show', $product->id) }}"
                                                class="prod-name-link">
                                                {{ \Illuminate\Support\Str::words($product->name, 4, '...') }}
                                            </a>
                                            <span class="prod-slug">{{ $product->brand->name ?? d_trans('Product') }}</span>
                                        </div>
                                        @if ($product->isFeatured())
                                            <span class="prod-badge prod-badge-featured">{{ d_trans('Featured') }}</span>
                                        @endif
                                    @else
                                        <div class="prod-thumb-placeholder">
                                            <i class="fa-solid fa-box-open"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <span class="prod-name-link">{{ d_trans('Deleted product') }}</span>
                                            <span class="prod-slug">{{ d_trans('No product record') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if ($user)
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('admin.members.users.edit', $user->id) }}">
                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}"
                                                class="review-avatar">
                                        </a>
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                                class="prod-name-link">{{ $user->getName() }}</a>
                                            <span class="prod-slug">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $reviewer?->avatar ?? asset(config('theme.settings.default_avatar', 'images/default-avatar.png')) }}"
                                            alt="{{ $reviewer?->name ?? d_trans('Deleted user') }}" class="review-avatar">
                                        <div class="min-w-0">
                                            <span class="prod-name-link">{{ $reviewer?->name ?? d_trans('Deleted user') }}</span>
                                            <span class="prod-slug">{{ $reviewer?->email ?? d_trans('No email available') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="review-stars">{!! $review->renderStars() !!}</span>
                            </td>
                            <td class="text-center">
                                @if ($review->is_approved)
                                    <span class="prod-badge prod-badge-active">{{ $review->getStatusName() }}</span>
                                @elseif ($review->is_flagged)
                                    <span class="prod-badge prod-badge-featured">{{ $review->getStatusName() }}</span>
                                @else
                                    <span class="prod-badge prod-badge-inactive">{{ $review->getStatusName() }}</span>
                                @endif
                            </td>
                            <td class="text-center prod-meta">{{ dateFormat($review->created_at) }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="prod-action-btn" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.reviews.show', $review->id) }}">
                                                <i class="fas fa-desktop me-2"></i>{{ d_trans('View Details') }}
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
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
                        @include('admin.partials.empty-table', ['colspan' => 7])
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="prod-pagination">
            {{ $reviews->links() }}
        </div>
    </div>

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

            .prod-btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
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
                border-bottom: 1px solid var(--prod-border);
                white-space: nowrap;
                background: var(--prod-bg);
                color: #64748b;
            }

            .prod-table tbody tr {
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                background: #ffffff;
                transition: background 0.15s;
            }

            .prod-table tbody tr:hover {
                background: linear-gradient(90deg, rgba(220, 38, 38, 0.035), #ffffff);
            }

            .prod-table tbody tr:last-child {
                border-bottom: none;
            }

            .prod-table td {
                padding: 12px 16px;
                color: var(--prod-text);
                vertical-align: middle;
            }

            .prod-id-link {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--prod-red);
                text-decoration: none;
            }

            .prod-id-link:hover,
            .prod-name-link:hover {
                color: var(--prod-red);
            }

            .prod-thumb,
            .review-avatar {
                width: 42px;
                height: 42px;
                object-fit: cover;
                border-radius: 8px;
                border: 1px solid var(--prod-border);
            }

            .prod-thumb {
                object-fit: contain;
            }

            .review-avatar {
                border-radius: 50%;
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

            .prod-badge-featured {
                background: rgba(245, 158, 11, 0.1);
                color: #b45309;
            }

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

            .review-stars {
                white-space: nowrap;
            }

            .prod-pagination {
                padding: 16px 24px;
                border-top: 1px solid var(--prod-border);
            }

            @media (max-width: 575px) {
                .prod-card-header {
                    padding: 16px;
                }

                .prod-table td,
                .prod-table thead th {
                    padding: 12px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.getElementById('reviewFiltersForm');
                if (!filterForm) return;

                filterForm.querySelectorAll('select').forEach(function(select) {
                    select.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });
            });
        </script>
    @endpush
@endsection
