@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Reviews'))
@section('title', d_trans('Review Details'))
@section('header_title', d_trans('Review #:review_id', ['review_id' => $review->id]))
@section('back', route('admin.reviews.index'))
@section('content')
    @php
        $user = $review->user;
        $reviewer = $review->reviewer;
        $product = $review->product;
        $reviewerName = $user?->getName() ?? $reviewer?->name ?? d_trans('Deleted user');
        $reviewerEmail = $user?->email ?? $reviewer?->email ?? d_trans('No email available');
        $reviewerAvatar = $user?->getAvatar() ?? $reviewer?->avatar ?? asset(config('theme.settings.default_avatar', 'images/default-avatar.png'));
    @endphp

    <div class="prod-hero mb-4">
        <div class="prod-hero-image">
            <img src="{{ $reviewerAvatar }}" alt="{{ $reviewerName }}">
        </div>
        <div class="prod-hero-info">
            <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div>
                    <h4 class="prod-hero-name">{{ $reviewerName }}</h4>
                    <span class="prod-hero-slug">{{ $reviewerEmail }}</span>
                </div>
                @if ($review->is_approved)
                    <span class="prod-status-pill prod-status-active">{{ $review->getStatusName() }}</span>
                @elseif ($review->is_flagged)
                    <span class="prod-status-pill prod-status-featured">{{ $review->getStatusName() }}</span>
                @else
                    <span class="prod-status-pill prod-status-inactive">{{ $review->getStatusName() }}</span>
                @endif
            </div>

            <div class="prod-hero-meta mt-3">
                <span class="prod-meta-chip">
                    <i class="fa-solid fa-hashtag me-1"></i>{{ $review->id }}
                </span>
                <span class="prod-meta-chip prod-meta-grade">
                    {!! $review->renderStars() !!}
                </span>
                <span class="prod-meta-chip">
                    <i class="fa-regular fa-calendar me-1"></i>{{ dateFormat($review->created_at) }}
                </span>
                @if ($product)
                    <a href="{{ route('admin.products.show', $product->id) }}" class="prod-meta-chip">
                        <i class="fa-solid fa-box me-1"></i>{{ $product->name }}
                    </a>
                @else
                    <span class="prod-meta-chip">
                        <i class="fa-solid fa-box-open me-1"></i>{{ d_trans('Deleted product') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="prod-detail-card">
                <div class="prod-detail-card-header">
                    <i class="fa-solid fa-message prod-detail-header-icon"></i>
                    <h6 class="prod-detail-card-title">{{ d_trans('Review') }}</h6>
                </div>
                <div class="prod-detail-card-body">
                    @if ($review->title)
                        <h5 class="review-title">{{ $review->title }}</h5>
                    @endif
                    <div class="review-body">
                        {!! purifier($review->body) !!}
                    </div>
                </div>
            </div>

            <div class="prod-detail-card mt-4">
                <div class="prod-detail-card-header">
                    <i class="fa-solid fa-box prod-detail-header-icon"></i>
                    <h6 class="prod-detail-card-title">{{ d_trans('Reviewed Product') }}</h6>
                </div>
                <div class="prod-detail-card-body">
                    <div class="review-product-row">
                        @if ($product)
                            <a href="{{ route('admin.products.show', $product->id) }}">
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="review-product-img">
                                @else
                                    <div class="review-product-placeholder">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="min-w-0">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="review-product-title">
                                    {{ $product->name }}
                                </a>
                                <span class="review-product-meta">{{ $product->brand->name ?? d_trans('Product') }}</span>
                            </div>
                        @else
                            <div class="review-product-placeholder">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="review-product-title">{{ d_trans('Deleted product') }}</span>
                                <span class="review-product-meta">{{ d_trans('No product record') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="prod-detail-card prod-info-card">
                <div class="prod-detail-card-header">
                    <i class="fa-solid fa-clipboard-list prod-detail-header-icon"></i>
                    <h6 class="prod-detail-card-title">{{ d_trans('Quick Info') }}</h6>
                </div>
                <div class="prod-info-list">
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('ID') }}</span>
                        <span class="prod-info-value prod-info-id">#{{ $review->id }}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Rating') }}</span>
                        <span class="prod-info-value">{!! $review->renderStars() !!}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Helpful') }}</span>
                        <span class="prod-info-value">{{ $review->helpful_count ?? 0 }}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Submitted') }}</span>
                        <span class="prod-info-value">{{ dateFormat($review->created_at) }}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Status') }}</span>
                        <span class="prod-info-value">
                            @if ($review->is_approved)
                                <span class="prod-badge prod-badge-active">{{ $review->getStatusName() }}</span>
                            @elseif ($review->is_flagged)
                                <span class="prod-badge prod-badge-featured">{{ $review->getStatusName() }}</span>
                            @else
                                <span class="prod-badge prod-badge-inactive">{{ $review->getStatusName() }}</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="prod-actions-card mt-4">
                <p class="prod-actions-title">{{ d_trans('Quick Actions') }}</p>
                <div class="d-flex flex-column gap-2">
                    @if ($review->is_approved)
                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="prod-action-link prod-action-danger action-confirm w-100">
                                <i class="fa-solid fa-xmark"></i>{{ d_trans('Reject Review') }}
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="prod-action-link prod-action-success action-confirm w-100">
                                <i class="fa-solid fa-check"></i>{{ d_trans('Approve Review') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
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

            .prod-hero {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 14px;
                padding: 24px;
                display: flex;
                gap: 20px;
                align-items: flex-start;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            }

            .prod-hero-image {
                width: 80px;
                height: 80px;
                min-width: 80px;
                border-radius: 50%;
                overflow: hidden;
                border: 1px solid var(--prod-border);
            }

            .prod-hero-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .prod-hero-info {
                flex: 1;
                min-width: 0;
            }

            .prod-hero-name {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--prod-text);
                margin: 0 0 4px;
            }

            .prod-hero-slug {
                font-size: 0.8rem;
                color: var(--prod-muted);
            }

            .prod-status-pill {
                display: inline-flex;
                align-items: center;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .prod-status-active,
            .prod-badge-active,
            .prod-action-success {
                background: rgba(22, 163, 74, 0.1);
                color: #15803d;
            }

            .prod-status-inactive,
            .prod-badge-inactive {
                background: rgba(220, 38, 38, 0.1);
                color: #dc2626;
            }

            .prod-status-featured,
            .prod-badge-featured {
                background: rgba(245, 158, 11, 0.1);
                color: #b45309;
            }

            .prod-hero-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .prod-meta-chip {
                display: inline-flex;
                align-items: center;
                padding: 4px 12px;
                background: var(--prod-bg);
                border: 1px solid var(--prod-border);
                border-radius: 20px;
                font-size: 0.75rem;
                color: var(--prod-muted);
                text-decoration: none;
            }

            .prod-meta-chip:hover {
                color: var(--prod-red);
                border-color: rgba(220, 38, 38, 0.2);
            }

            .prod-meta-grade {
                background: var(--prod-red-soft);
                color: var(--prod-red);
                border-color: rgba(220, 38, 38, 0.2);
            }

            .prod-detail-card {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            }

            .prod-detail-card-header {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 16px 20px;
                border-bottom: 1px solid var(--prod-border);
                background: var(--prod-bg);
            }

            .prod-detail-header-icon {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                background: var(--prod-red-soft);
                color: var(--prod-red);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.85rem;
            }

            .prod-detail-card-title {
                margin: 0;
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--prod-text);
            }

            .prod-detail-card-body {
                padding: 24px;
            }

            .review-title {
                margin: 0 0 14px;
                color: var(--prod-text);
                font-size: 1rem;
                font-weight: 700;
            }

            .review-body {
                color: var(--prod-text);
                font-size: 0.95rem;
                line-height: 1.7;
            }

            .review-body p:last-child {
                margin-bottom: 0;
            }

            .review-product-row {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .review-product-img,
            .review-product-placeholder {
                width: 64px;
                height: 64px;
                border-radius: 10px;
                border: 1px solid var(--prod-border);
            }

            .review-product-img {
                object-fit: contain;
            }

            .review-product-placeholder {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: var(--prod-bg);
                color: var(--prod-muted);
                font-size: 1.2rem;
            }

            .review-product-title {
                display: block;
                color: var(--prod-text);
                font-size: 0.95rem;
                font-weight: 700;
                text-decoration: none;
            }

            .review-product-title:hover {
                color: var(--prod-red);
            }

            .review-product-meta {
                display: block;
                margin-top: 3px;
                color: var(--prod-muted);
                font-size: 0.8rem;
            }

            .prod-info-list {
                padding: 0 4px;
            }

            .prod-info-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                padding: 12px 16px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            }

            .prod-info-row:last-child {
                border-bottom: none;
            }

            .prod-info-label {
                font-size: 0.78rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                color: var(--prod-muted);
            }

            .prod-info-value {
                font-size: 0.85rem;
                color: var(--prod-text);
                font-weight: 500;
                text-align: right;
            }

            .prod-info-id {
                color: var(--prod-red);
                font-weight: 700;
            }

            .prod-badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 10px;
                border-radius: 20px;
                font-size: 0.7rem;
                font-weight: 600;
            }

            .prod-actions-card {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 12px;
                padding: 20px;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            }

            .prod-actions-title {
                font-size: 0.7rem;
                font-weight: 700;
                color: rgba(220, 38, 38, 0.5);
                text-transform: uppercase;
                letter-spacing: 0.8px;
                margin: 0 0 14px;
            }

            .prod-action-link {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                padding: 10px 14px;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                border: 1px solid var(--prod-border);
                transition: background 0.18s, color 0.18s, border-color 0.18s;
                cursor: pointer;
            }

            .prod-action-link:hover {
                border-color: rgba(220, 38, 38, 0.2);
            }

            .prod-action-danger {
                color: #dc2626;
                background: rgba(220, 38, 38, 0.04);
            }

            .prod-action-danger:hover {
                background: rgba(220, 38, 38, 0.1);
                color: #dc2626;
            }

            .prod-action-success:hover {
                background: rgba(22, 163, 74, 0.16);
                color: #15803d;
            }

            @media (max-width: 575px) {
                .prod-hero {
                    padding: 18px;
                    flex-direction: column;
                }

                .prod-detail-card-body {
                    padding: 18px;
                }
            }
        </style>
    @endpush
@endsection
