@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Edit Product'))
@section('header_title', d_trans('Edit :product_name', ['product_name' => $product->name]))
@section('back', route('admin.products.index'))
@section('content')

    @include('admin.products.includes.hero')
    @include('admin.products.includes.tabs')

    <div class="prod-detail-card mt-4">
        <div class="prod-detail-card-header">
            <i class="fa-solid fa-pen prod-detail-header-icon"></i>
            <h6 class="prod-detail-card-title">{{ d_trans('Edit Product') }}</h6>
        </div>
        <div class="prod-detail-card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.products.partials.form', [
                    'buttonLabel' => d_trans('Save Changes'),
                    'brands' => $brands,
                    'categories' => $categories,
                    'subCategories' => $subCategories,
                    'ingredientLibraries' => $ingredientLibraries,
                    'grades' => $grades,
                ])
            </form>
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

            /* Hero */
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

            /* Tabs */
            .dashboard-tabs {
                /* border-bottom: 2px solid var(--prod-border); */
                margin-bottom: 0;
                display: flex;
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

            /* Detail Card */
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
        </style>
    @endpush

@endsection
