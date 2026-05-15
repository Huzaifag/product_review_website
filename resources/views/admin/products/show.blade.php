@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Product Details'))
@section('header_title', d_trans(':product_name Details', ['product_name' => $product->name]))
@section('back', route('admin.products.index'))
@section('content')

    {{-- Product Hero Header --}}
    @include('admin.products.includes.hero')

    {{-- Tabs --}}
    @include('admin.products.includes.tabs')

    <div class="row g-4">

        {{-- Left: Form --}}
        <div class="col-lg-8">
            <div class="prod-detail-card">
                <div class="prod-detail-card-header">
                    <i class="fa-solid fa-circle-info prod-detail-header-icon"></i>
                    <h6 class="prod-detail-card-title">{{ d_trans('Product Details') }}</h6>
                </div>
                <div class="prod-detail-card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.products.partials.form', [
                            'buttonLabel' => d_trans('Save Changes'),
                        ])
                    </form>
                </div>
            </div>

            @if ($product->images->count() > 0)
                <div class="prod-detail-card mt-4">
                    <div class="prod-detail-card-header">
                        <i class="fa-solid fa-images prod-detail-header-icon"></i>
                        <h6 class="prod-detail-card-title">{{ d_trans('Product Images') }}</h6>
                    </div>
                    <div class="prod-detail-card-body">
                        @php
                            $mainImagePath = $product->image ?: $product->images->first()?->path ?? null;
                            $galleryImages = $product->images->reject(function ($image) use ($mainImagePath) {
                                return $image->path === $mainImagePath;
                            });
                        @endphp
                        <div class="d-flex flex-wrap gap-3">
                            @if ($mainImagePath)
                                <div class="prod-gallery-thumb prod-gallery-main">
                                    <img src="{{ asset($mainImagePath) }}" alt="{{ $product->name }}">
                                    <span class="prod-gallery-label">{{ d_trans('Main') }}</span>
                                </div>
                            @endif
                            @foreach ($galleryImages as $image)
                                <div class="prod-gallery-thumb">
                                    <img src="{{ asset($image->path) }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Info Sidebar --}}
        <div class="col-lg-4">
            <div class="prod-detail-card prod-info-card">
                <div class="prod-detail-card-header">
                    <i class="fa-solid fa-clipboard-list prod-detail-header-icon"></i>
                    <h6 class="prod-detail-card-title">{{ d_trans('Quick Info') }}</h6>
                </div>
                <div class="prod-info-list">
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('ID') }}</span>
                        <span class="prod-info-value prod-info-id">#{{ $product->id }}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Brand') }}</span>
                        <span class="prod-info-value">{{ $product->brand->name ?? '-' }}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Category') }}</span>
                        <span class="prod-info-value">{{ $product->category->trans->name ?? '-' }}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Sub Category') }}</span>
                        <span class="prod-info-value">{{ $product->subCategory->trans->name ?? '-' }}</span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Overall Grade') }}</span>
                        <span class="prod-info-value">
                            @if ($product->overall_grade)
                                <span class="prod-badge prod-badge-grade">
                                    {{ str_replace('_', ' ', ucfirst($product->overall_grade)) }}
                                </span>
                            @else
                                --
                            @endif
                        </span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Status') }}</span>
                        <span class="prod-info-value">
                            @if ($product->is_active)
                                <span class="prod-badge prod-badge-active">{{ d_trans('Active') }}</span>
                            @else
                                <span class="prod-badge prod-badge-inactive">{{ d_trans('Inactive') }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Featured') }}</span>
                        <span class="prod-info-value">
                            @if ($product->is_featured)
                                <span class="prod-badge prod-badge-featured">{{ d_trans('Yes') }}</span>
                            @else
                                <span class="prod-badge prod-badge-no">{{ d_trans('No') }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="prod-info-row">
                        <span class="prod-info-label">{{ d_trans('Created At') }}</span>
                        <span class="prod-info-value">{{ dateFormat($product->created_at) }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="prod-actions-card mt-4">
                <p class="prod-actions-title">{{ d_trans('Quick Actions') }}</p>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="prod-action-link">
                        <i class="fa-solid fa-pen"></i> {{ d_trans('Edit Product') }}
                    </a>
                    <a href="{{ route('admin.products.lab-tests', $product->id) }}" class="prod-action-link">
                        <i class="fa-solid fa-flask-vial"></i> {{ d_trans('Manage Lab Tests') }}
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="prod-action-link prod-action-danger action-confirm w-100">
                            <i class="fa-solid fa-trash"></i> {{ d_trans('Delete Product') }}
                        </button>
                    </form>
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

            /* Hero Header */
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
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid var(--prod-border);
            }

            .prod-hero-image img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .prod-hero-placeholder {
                width: 100%;
                height: 100%;
                background: var(--prod-bg);
                display: flex;
                align-items: center;
                justify-content: center;
                color: rgba(220, 38, 38, 0.4);
                font-size: 1.6rem;
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

            .prod-status-active {
                background: rgba(22, 163, 74, 0.1);
                color: #15803d;
            }

            .prod-status-inactive {
                background: rgba(220, 38, 38, 0.1);
                color: #dc2626;
            }

            .prod-status-featured {
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
            }

            .prod-meta-grade {
                background: var(--prod-red-soft);
                color: var(--prod-red);
                border-color: rgba(220, 38, 38, 0.2);
            }

            /* Tabs override */
            .dashboard-tabs {
                /* border-bottom: 2px solid var(--prod-border); */
                margin-bottom: 0;
                display: flex;
                gap: 0;
            }

            .dashboard-tabs-item {
                padding: 10px 20px;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--prod-muted);
                text-decoration: none;
                border-bottom: 2px solid transparent;
                margin-bottom: -2px;
                transition: color 0.18s, border-color 0.18s;
            }

            .dashboard-tabs-item:hover {
                color: var(--prod-red);
            }

            .dashboard-tabs-item.current {
                color: var(--prod-red);
                border-bottom-color: var(--prod-red);
                font-weight: 600;
            }

            /* Detail Cards */
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

            /* Gallery */
            .prod-gallery-thumb {
                position: relative;
                width: 88px;
                height: 88px;
                border-radius: 10px;
                overflow: hidden;
                border: 2px solid var(--prod-border);
            }

            .prod-gallery-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .prod-gallery-main {
                border-color: rgba(220, 38, 38, 0.4);
            }

            .prod-gallery-label {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(220, 38, 38, 0.85);
                color: #fff;
                font-size: 0.6rem;
                font-weight: 700;
                text-align: center;
                padding: 3px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Info Sidebar */
            .prod-info-list {
                padding: 0 4px;
            }

            .prod-info-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 16px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            }

            .prod-info-row:last-child {
                border-bottom: none;
            }

            .prod-info-label {
                font-size: 0.78rem;
                font-weight: 600;
                /* color: rgba(220, 38, 38, 0.55); */
                text-transform: uppercase;
                letter-spacing: 0.4px;
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

            /* Badges */
            .prod-badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 10px;
                border-radius: 20px;
                font-size: 0.7rem;
                font-weight: 600;
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
                background: var(--prod-red-soft);
                color: #b91c1c;
                border: 1px solid rgba(220, 38, 38, 0.2);
            }

            .prod-badge-featured {
                background: rgba(245, 158, 11, 0.1);
                color: #b45309;
            }

            .prod-badge-no {
                background: rgba(100, 116, 139, 0.1);
                color: #475569;
            }

            /* Quick Actions Card */
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
                gap: 10px;
                padding: 10px 14px;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--prod-text);
                text-decoration: none;
                background: var(--prod-bg);
                border: 1px solid var(--prod-border);
                transition: background 0.18s, color 0.18s, border-color 0.18s;
                cursor: pointer;
            }

            .prod-action-link:hover {
                background: var(--prod-red-soft);
                color: var(--prod-red);
                border-color: rgba(220, 38, 38, 0.2);
            }

            .prod-action-danger {
                color: #dc2626;
                background: rgba(220, 38, 38, 0.04);
            }

            .prod-action-danger:hover {
                background: rgba(220, 38, 38, 0.1);
            }
        </style>
    @endpush

@endsection
