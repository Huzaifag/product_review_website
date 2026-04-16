@extends('themes.basic.layouts.single')
@section('title', $product->name)
@section('header_title', $product->name)
@section('description', $product->description)
@section('keywords', $product->brand_name . ',' . $product->name)
@section('breadcrumbs', Breadcrumbs::render('products.show', $product))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'products.show', $product))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')
    @push('styles')
        <style>
            :root {
                --cream: #f5f0e8;
                --cream-dark: #ede8df;
                --green-dark: #2c3d2e;
                --green-mid: #3a5140;
                --tan: #c4a882;
                --text-dark: #1e2820;
                --text-mid: #4a5240;
                --text-light: #7a826e;
                --border: #ddd8ce;
                --selected-bg: #e8eef2;
                --selected-border: #b8cad4;
            }

            *,
            *::before,
            *::after {
                box-sizing: border-box;
            }


            /* ── Card wrapper ── */
            .card-shell {
                background: var(--cream);
                border-radius: 20px;
                overflow: hidden;
                width: 100%;
                box-shadow: 0 32px 80px rgba(0, 0, 0, .28);
            }

            /* ── Announcement bar ── */
            .announce-bar {
                background: var(--cream-dark);
                text-align: center;
                font-size: .72rem;
                letter-spacing: .04em;
                padding: 8px 16px;
                color: var(--text-mid);
                border-bottom: 1px solid var(--border);
            }

            .announce-bar strong {
                color: var(--text-dark);
            }

            .announce-bar code {
                font-family: 'DM Sans', sans-serif;
                background: rgba(0, 0, 0, .06);
                border-radius: 4px;
                padding: 1px 5px;
                font-size: .68rem;
                letter-spacing: .06em;
            }

            /* ── Nav ── */
            .site-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 14px 28px;
                border-bottom: 1px solid var(--border);
            }

            .nav-links {
                display: flex;
                gap: 20px;
            }

            .nav-links a,
            .nav-right a {
                font-size: .78rem;
                color: var(--text-mid);
                text-decoration: none;
                letter-spacing: .02em;
            }

            .nav-links a:hover,
            .nav-right a:hover {
                color: var(--text-dark);
            }

            .site-logo {
                /* font-family: 'Playfair Display', serif; */
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--text-dark);
                letter-spacing: .02em;
            }

            .nav-right {
                display: flex;
                align-items: center;
                gap: 18px;
            }

            .nav-right svg {
                width: 17px;
                height: 17px;
                stroke: var(--text-mid);
                fill: none;
                cursor: pointer;
            }

            .cart-wrap {
                position: relative;
            }

            .cart-badge {
                position: absolute;
                top: -5px;
                right: -6px;
                background: var(--green-dark);
                color: #fff;
                font-size: .5rem;
                width: 13px;
                height: 13px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* ── Body content ── */
            .product-body {
                display: flex;
                gap: 0;
            }

            /* LEFT column */
            .img-col {
                width: 50%;
                flex-shrink: 0;
                background: var(--cream-dark);
                padding: 24px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                overflow-y: auto;
                /* max-height: 100vh; */
            }

            .img-main {
                width: 100%;
                aspect-ratio: 1 / 1;
                background: linear-gradient(145deg, #dcd4c4 0%, #c8bfad 100%);
                border-radius: 12px;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                flex-shrink: 0;
            }

            .img-main img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Coffee bag illustration (pure CSS) */
            .bag {
                position: relative;
                width: 120px;
                margin-bottom: -8px;
            }

            .bag-body {
                width: 120px;
                height: 160px;
                background: linear-gradient(160deg, #2e4430 0%, #1e2e20 100%);
                border-radius: 10px 10px 6px 6px;
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                box-shadow: 4px 8px 24px rgba(0, 0, 0, .35), inset 2px 0 8px rgba(255, 255, 255, .05);
            }

            .bag-top {
                width: 100px;
                height: 28px;
                background: linear-gradient(160deg, #2e4430 0%, #1e2e20 100%);
                border-radius: 50% 50% 0 0 / 60% 60% 0 0;
                margin: 0 auto;
                position: absolute;
                top: -18px;
                left: 10px;
                box-shadow: 0 -2px 8px rgba(0, 0, 0, .2);
            }

            .bag-logo-circle {
                width: 52px;
                height: 52px;
                border-radius: 50%;
                border: 1.5px solid rgba(255, 255, 255, .25);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 6px;
            }

            .bag-logo-circle svg {
                width: 32px;
                height: 32px;
            }

            .bag-brand {
                /* font-family: 'Playfair Display', serif; */
                font-size: .52rem;
                color: rgba(255, 255, 255, .8);
                letter-spacing: .08em;
                text-align: center;
                line-height: 1.4;
            }

            .bag-label {
                position: absolute;
                bottom: 22px;
                left: 50%;
                transform: translateX(-50%);
                background: var(--cream);
                border-radius: 4px;
                padding: 3px 10px;
                font-size: .5rem;
                font-weight: 500;
                color: var(--text-dark);
                white-space: nowrap;
                letter-spacing: .03em;
            }

            .beans-scatter {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 70px;
            }

            .bean {
                position: absolute;
                background: #3d2010;
                border-radius: 50%;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, .3);
            }

            .img-thumbs {
                display: flex;
                gap: 10px;
                flex-shrink: 0;
            }

            .img-thumb {
                flex: 1;
                aspect-ratio: 1 / 1;
                background: #b8a890;
                border-radius: 10px;
                overflow: hidden;
                position: relative;
                border: 1.5px solid transparent;
                cursor: pointer;
                padding: 0;
                transition: border-color .2s ease, transform .2s ease;
            }

            .img-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .img-thumb.active {
                border-color: var(--selected-border);
                transform: translateY(-2px);
            }

            .img-view-all-btn {
                flex: 1;
                aspect-ratio: 1 / 1;
                background: rgba(44, 61, 46, 0.1);
                border: 1.5px dashed var(--border);
                border-radius: 10px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all .2s ease;
                font-size: 2.5rem;
                color: var(--text-dark);
            }

            .img-view-all-btn:hover {
                border-color: var(--green-dark);
                background: rgba(44, 61, 46, 0.15);
            }

            .thumb-pour {
                background: linear-gradient(135deg, #c8b89a 0%, #a89070 100%);
            }

            .thumb-beans {
                background: linear-gradient(135deg, #8a6a40 0%, #5a3a18 100%);
            }

            /* Pour-over illustration */
            .pour-scene {
                position: absolute;
                inset: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .kettle {
                width: 32px;
                height: 20px;
                background: #f0ede8;
                border-radius: 8px 2px 2px 8px;
                position: relative;
                margin-bottom: 4px;
            }

            .kettle::after {
                content: '';
                position: absolute;
                right: -8px;
                top: 50%;
                transform: translateY(-50%);
                width: 8px;
                height: 2px;
                background: #d0cdc8;
                border-radius: 2px;
            }

            .dripper {
                width: 24px;
                height: 18px;
                background: #f0ede8;
                clip-path: polygon(10% 0%, 90% 0%, 70% 100%, 30% 100%);
                margin-bottom: 2px;
            }

            .carafe {
                width: 22px;
                height: 26px;
                background: rgba(240, 237, 232, .6);
                border-radius: 4px 4px 6px 6px;
                border: 1.5px solid #d0cdc8;
            }

            /* Beans in hand */
            .beans-scene {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .hand-shape {
                width: 44px;
                height: 30px;
                background: #c8906a;
                border-radius: 50% 50% 30% 30%;
                position: relative;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 2px;
                padding: 4px;
            }

            .mini-bean {
                width: 7px;
                height: 5px;
                background: #3d2010;
                border-radius: 50%;
            }

            /* RIGHT column */
            .detail-col {
                flex: 1;
                padding: 28px 28px 24px;
                display: flex;
                flex-direction: column;
            }

            .eyebrow {
                font-size: .65rem;
                letter-spacing: .12em;
                text-transform: uppercase;
                color: var(--text-light);
                margin-bottom: 4px;
            }

            .product-title {
                font-size: 2.2rem;
                font-weight: 700;
                color: var(--text-dark);
                line-height: 1.1;
                margin: 0 0 8px;
            }

            .tags {
                display: flex;
                gap: 8px;
                align-items: center;
                margin-bottom: 16px;
                font-size: .72rem;
                color: var(--text-light);
            }

            .tags span {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .tags .dot {
                width: 3px;
                height: 3px;
                border-radius: 50%;
                background: var(--text-light);
                display: inline-block;
            }

            .product-desc {
                font-size: .82rem;
                line-height: 1.7;
                color: var(--text-mid);
                margin-bottom: 20px;
            }

            .details-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 16px;
            }

            .detail-item {
                border: 1px solid var(--border);
                border-radius: 10px;
                padding: 10px 12px;
                background: #f9f4eb;
            }

            .detail-item-label {
                font-size: .66rem;
                text-transform: uppercase;
                letter-spacing: .08em;
                color: var(--text-light);
                margin-bottom: 4px;
            }

            .detail-item-value {
                font-size: .83rem;
                color: var(--text-dark);
                font-weight: 600;
                line-height: 1.35;
            }

            .lab-box {
                border: 1px solid var(--border);
                border-radius: 12px;
                background: #f8f2e8;
                padding: 12px;
                margin-bottom: 14px;
            }

            .lab-title {
                font-size: .8rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 8px;
            }

            .lab-list {
                margin: 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 6px;
            }

            .lab-list li {
                display: flex;
                justify-content: space-between;
                gap: 10px;
                font-size: .75rem;
                color: var(--text-mid);
                border-bottom: 1px dashed rgba(122, 130, 110, .35);
                padding-bottom: 4px;
            }

            left-test-section {
                border: 1px solid var(--border);
                border-radius: 12px;
                background: #f8f2e8;
                padding: 12px;
                margin-bottom: 14px;
                flex-shrink: 0;
            }

            .left-section-title {
                font-size: .8rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 8px;
            }

            .concern-list {
                max-height: 180px;
                overflow: auto;
                display: grid;
                gap: 8px;
            }

            .concern-item {
                border: 1px solid var(--border);
                border-radius: 10px;
                padding: 9px 10px;
                background: #fff;
            }

            .concern-item h6 {
                font-size: .78rem;
                margin: 0 0 3px;
                color: var(--text-dark);
            }

            .concern-item p {
                margin: 0;
                font-size: .72rem;
                color: var(--text-mid);
                line-height: 1.45;
            }

            /* Image Modal */
            .modal-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                z-index: 2000;
                align-items: center;
                justify-content: center;
            }

            .modal-overlay.active {
                display: flex;
            }

            .modal-content {
                background: #fff;
                border-radius: 16px;
                padding: 24px;
                max-width: 90vw;
                max-height: 90vh;
                overflow-y: auto;
                position: relative;
            }

            .modal-close {
                position: absolute;
                top: 12px;
                right: 12px;
                width: 32px;
                height: 32px;
                background: var(--cream-dark);
                border: none;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                color: var(--text-dark);
            }

            .modal-close:hover {
                background: var(--cream);
            }

            .modal-images-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 12px;
                margin-top: 20px;
            }

            .modal-image {
                aspect-ratio: 1 / 1;
                border-radius: 12px;
                overflow: hidden;
                cursor: pointer;
                border: 2px solid transparent;
                transition: border-color .2s ease, transform .2s ease;
            }

            .modal-image:hover {
                border-color: var(--green-dark);
                transform: scale(1.05);
            }

            .modal-image img {
                width: 100%;
                height: 100%;
                object-fit: cover gap: 8px;
            }

            .concern-item {
                border: 1px solid var(--border);
                border-radius: 10px;
                padding: 9px 10px;
                background: #fff;
            }

            .concern-item h6 {
                font-size: .78rem;
                margin: 0 0 3px;
                color: var(--text-dark);
            }

            .concern-item p {
                margin: 0;
                font-size: .72rem;
                color: var(--text-mid);
                line-height: 1.45;
            }

            /* Roast selector */
            .roast-grid {
                display: flex;
                gap: 16px;
                margin-bottom: 20px;
            }

            .roast-card {
                flex: 1;
                border: 2px solid #e5e0d5;
                border-radius: 12px;
                padding: 16px 12px 14px;
                text-align: center;
                cursor: pointer;
                transition: all .25s ease;
                background: #f9f6f0;
                display: flex;
                flex-direction: column;
                align-items: center;
                min-height: 180px;
            }

            .roast-card:hover {
                border-color: #d9cfc5;
                background: #faf8f4;
            }

            .roast-card.active {
                background: #f0f4f8;
                border-color: #8db5d1;
                box-shadow: none;
            }

            .roast-img {
                width: 80px;
                height: 100px;
                margin: 0 auto 12px;
                border-radius: 8px;
                background: #f5f1e8;
                position: relative;
                overflow: hidden;
                border: 1px solid #e8dfd2;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .roast-img img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                padding: 4px;
            }

            .roast-mini-logo {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .roast-mini-logo svg {
                width: 20px;
                height: 20px;
            }

            .roast-name {
                /* font-family: 'Playfair Display', serif; */
                font-size: .88rem;
                font-weight: 600;
                color: #2c3a2e;
                margin-bottom: 3px;
                line-height: 1.2;
            }

            .roast-sub {
                font-size: .65rem;
                color: #7a826e;
                line-height: 1.3;
            }

            /* Purchase options */
            .purchase-opts {
                display: flex;
                flex-direction: column;
                gap: 8px;
                margin-bottom: 14px;
            }

            .opt-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                border: 1.5px solid var(--border);
                border-radius: 10px;
                padding: 11px 14px;
                cursor: pointer;
                transition: border-color .2s;
            }

            .opt-row:hover {
                border-color: var(--tan);
            }

            .opt-row.active {
                border-color: var(--green-dark);
                background: rgba(44, 61, 46, .03);
            }

            .opt-left {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .radio-ring {
                width: 17px;
                height: 17px;
                border-radius: 50%;
                border: 1.5px solid var(--border);
                flex-shrink: 0;
                position: relative;
            }

            .opt-row.active .radio-ring {
                border-color: var(--green-dark);
            }

            .opt-row.active .radio-ring::after {
                content: '';
                position: absolute;
                inset: 3px;
                background: var(--green-dark);
                border-radius: 50%;
            }

            .opt-label {
                font-size: .78rem;
                color: var(--text-dark);
                font-weight: 500;
            }

            .opt-label span {
                font-size: .7rem;
                color: var(--text-light);
                font-weight: 400;
            }

            .opt-price {
                font-size: .8rem;
                color: var(--text-dark);
                font-weight: 500;
                display: flex;
                gap: 6px;
                align-items: center;
            }

            .opt-price .original {
                color: var(--text-light);
                text-decoration: line-through;
                font-weight: 400;
                font-size: .73rem;
            }

            /* Frequency dropdown */
            .freq-select {
                width: 100%;
                border: 1.5px solid var(--border);
                border-radius: 9px;
                padding: 9px 14px;
                font-family: 'DM Sans', sans-serif;
                font-size: .78rem;
                color: var(--text-light);
                background: var(--cream) url("data:image/svg+xml,%3Csvg width='12' height='7' viewBox='0 0 12 7' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237a826e' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 12px center;
                appearance: none;
                margin-bottom: 10px;
                cursor: pointer;
            }

            .freq-select:focus {
                outline: none;
                border-color: var(--green-dark);
            }

            /* Perks */
            .perks {
                display: flex;
                gap: 12px;
                margin-bottom: 18px;
                flex-wrap: wrap;
            }

            .perk {
                display: flex;
                align-items: center;
                gap: 5px;
                font-size: .68rem;
                color: var(--text-light);
            }

            .perk svg {
                width: 14px;
                height: 14px;
                stroke: var(--text-light);
                flex-shrink: 0;
            }

            /* Add to cart row */
            .cart-row {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: auto;
            }

            .qty-ctrl {
                display: flex;
                align-items: center;
                gap: 0;
                border: 1.5px solid var(--border);
                border-radius: 9px;
                overflow: hidden;
                flex-shrink: 0;
            }

            .qty-btn {
                width: 34px;
                height: 42px;
                background: none;
                border: none;
                font-size: 1.1rem;
                color: var(--text-dark);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background .15s;
            }

            .qty-btn:hover {
                background: var(--cream-dark);
            }

            .qty-num {
                min-width: 28px;
                text-align: center;
                font-size: .85rem;
                font-weight: 500;
                color: var(--text-dark);
            }

            .btn-add {
                flex: 1;
                background: var(--green-dark);
                color: #fff;
                border: none;
                border-radius: 9px;
                padding: 11px 20px;
                font-family: 'DM Sans', sans-serif;
                font-size: .82rem;
                font-weight: 500;
                letter-spacing: .03em;
                cursor: pointer;
                transition: background .2s;
            }

            .btn-add:hover {
                background: var(--green-mid);
            }

            /* Responsive */
            @media (max-width: 700px) {
                .product-body {
                    flex-direction: column;
                }

                .img-col {
                    width: 100%;
                }

                .product-title {
                    font-size: 1.7rem;
                }

                .roast-grid {
                    gap: 7px;
                }

                .details-grid {
                    grid-template-columns: 1fr;
                }

                .cart-shell {
                    border-radius: 14px;
                }
            }
        </style>
    @endpush
    @php
        $productImageUrls = collect([$product->image])
            ->merge($product->images->pluck('path'))
            ->filter()
            ->map(function ($path) {
                return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']) ? $path : asset($path);
            })
            ->unique()
            ->values();

        if ($productImageUrls->isEmpty()) {
            $productImageUrls = collect([$product->getImageLink()]);
        }
    @endphp
    <div class="card-shell">
        <!-- Product body -->
        <div class="product-body">

            <!-- LEFT: Images -->
            <div class="img-col">
                <!-- Main product image -->
                <div class="img-main">
                    <img id="mainProductImage" src="{{ $productImageUrls->first() }}" alt="{{ $product->name }}">
                </div>

                <!-- Thumbnails - Show 4 images + View All button -->
                <div class="img-thumbs">
                    @foreach ($productImageUrls->take(3) as $index => $imageUrl)
                        <button type="button" class="img-thumb {{ $index === 0 ? 'active' : '' }}"
                            onclick="selectPreview(this, '{{ $imageUrl }}')">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                        </button>
                    @endforeach
                    @if ($productImageUrls->count() > 3)
                        <button type="button" class="img-view-all-btn" onclick="openImageModal()">
                            +
                        </button>
                    @endif
                </div>

                <!-- Ingredient Concerns Section -->
                @php
                    $concerns = $product->ingredientConcerns;
                @endphp
                @if ($concerns->count() > 0)
                    <div class="left-test-section">
                        <div class="left-section-title">{{ d_trans('Ingredient Concerns') }}</div>
                        <div class="concern-list">
                            @foreach ($concerns as $concern)
                                <div class="concern-item">
                                    <h6>
                                        {{ $concern->ingredient_name }}
                                        <span class="lab-badge">{{ ucfirst($concern->severity) }}</span>
                                    </h6>
                                    <p>{{ $concern->description ?: d_trans('No description provided.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Test Summary Section -->
                @php
                    $lab = $product->labTestingResult;
                @endphp
                @if ($lab?->test_summary)
                    <div class="left-test-section">
                        <div class="left-section-title">{{ d_trans('Test Summary') }}</div>
                        <p style="margin:0;font-size:.75rem;color:var(--text-mid);line-height:1.55;">
                            {{ $lab->test_summary }}
                        </p>
                    </div>
                @endif
            </div><!-- /img-col -->

            <!-- RIGHT: Product details -->
            <div class="detail-col">
                @php
                    $lab = $product->labTestingResult;
                    $concerns = $product->ingredientConcerns;
                @endphp
                <p class="eyebrow">{{ d_trans('Lab-Tested Product') }}</p>
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="tags">
                    <span>{{ $product->brand->name ?: d_trans('Unknown brand') }}</span>
                    <span class="dot"></span>
                    <span>{{ $product->category->trans->name ?? d_trans('Uncategorized') }}</span>
                    <span class="dot"></span>
                    <span>{{ $product->subCategory->trans->name ?? d_trans('No sub category') }}</span>
                </div>

                <p class="product-desc">
                    {{ \Illuminate\Support\Str::limit(strip_tags($product->description ?: d_trans('No description available for this product.')), 220) }}
                </p>

                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-item-label">{{ d_trans('Overall Grade') }}</div>
                        <div class="detail-item-value">
                            {{ $product->overall_grade ? str_replace('_', ' ', ucfirst($product->overall_grade)) : d_trans('N/A') }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">{{ d_trans('Test Date') }}</div>
                        <div class="detail-item-value">
                            {{ $product->test_date ? $product->test_date->format('M d, Y') : d_trans('N/A') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">{{ d_trans('Price') }}</div>
                        <div class="detail-item-value">
                            @if ($product->price)
                                {{ $product->currency }} {{ numberFormat($product->price) }}
                            @else
                                {{ d_trans('N/A') }}
                            @endif
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">{{ d_trans('Size') }}</div>
                        <div class="detail-item-value">{{ $product->product_size ?: d_trans('N/A') }}</div>
                    </div>
                </div>

                <!-- Roast selector -->
                <div class="roast-grid">
                    @php
                        $category = $product->category;
                        $subCategory = $product->subCategory;
                        $categoryImage = $category?->image
                            ? (\Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://'])
                                ? $category->image
                                : asset($category->image))
                            : asset('images/placeholder.png');
                        $subCategoryImage = $subCategory?->image
                            ? (\Illuminate\Support\Str::startsWith($subCategory->image, ['http://', 'https://'])
                                ? $subCategory->image
                                : asset($subCategory->image))
                            : asset('images/placeholder.png');

                        $brand = $product->brand;
                        $brandImage = $brand?->logo
                            ? (\Illuminate\Support\Str::startsWith($brand->logo, ['http://', 'https://'])
                                ? $brand->logo
                                : asset($brand->logo))
                            : asset('images/placeholder.png');
                    @endphp
                    <!-- Brand Info Card -->
                    <div class="roast-card" onclick="selectRoast(this)">
                        <div class="roast-img">
                            <img src="{{ $brandImage }}" alt="{{ $brand?->name }}">
                        </div>
                        <div class="roast-name">{{ $brand?->name ?: d_trans('Unknown brand') }}</div>
                        <div class="roast-sub">{{ d_trans('Brand') }}</div>
                    </div>

                    <!-- Category Card -->
                    <div class="roast-card active" onclick="selectRoast(this)">
                        <div class="roast-img">
                            <img src="{{ $categoryImage }}" alt="{{ $category?->trans->name }}">
                        </div>
                        <div class="roast-name">{{ $category?->trans->name ?: d_trans('Category') }}</div>
                        <div class="roast-sub">{{ d_trans('Category') }}</div>
                    </div>

                    <!-- Sub Category Card -->
                    <div class="roast-card" onclick="selectRoast(this)">
                        <div class="roast-img">
                            <img src="{{ $subCategoryImage }}" alt="{{ $subCategory?->trans->name }}">
                        </div>
                        <div class="roast-name">{{ $subCategory?->trans->name ?: d_trans('Sub Category') }}</div>
                        <div class="roast-sub">{{ d_trans('Sub Category') }}</div>
                    </div>


                </div>

                <div class="lab-box">
                    <div class="lab-title">{{ d_trans('Lab Test Snapshot') }}</div>
                    <ul class="lab-list">
                        <li>
                            <span>{{ d_trans('Lab Name') }}</span>
                            <strong>{{ $lab?->lab_name ?: d_trans('N/A') }}</strong>
                        </li>
                        <li>
                            <span>{{ d_trans('Ingredient Grade') }}</span>
                            <strong>{{ $lab?->ingredient_grade ? str_replace('_', ' ', ucfirst($lab->ingredient_grade)) : d_trans('N/A') }}</strong>
                        </li>
                        <li>
                            <span>{{ d_trans('Defects Grade') }}</span>
                            <strong>{{ $lab?->defects_grade ? str_replace('_', ' ', ucfirst($lab->defects_grade)) : d_trans('N/A') }}</strong>
                        </li>
                        <li>
                            <span>{{ d_trans('Overall Grade') }}</span>
                            <strong>{{ $lab?->overall_grade ? str_replace('_', ' ', ucfirst($lab->overall_grade)) : d_trans('N/A') }}</strong>
                        </li>
                        <li>
                            <span>{{ d_trans('Fragrance') }}</span>
                            <strong>{{ $lab ? ($lab->has_fragrance ? d_trans('Yes') : d_trans('No')) : d_trans('N/A') }}</strong>
                        </li>
                        <li>
                            <span>{{ d_trans('Concerning UV Filter') }}</span>
                            <strong>{{ $lab ? ($lab->concerning_uv_filter ? d_trans('Yes') : d_trans('No')) : d_trans('N/A') }}</strong>
                        </li>
                    </ul>
                </div>
            </div><!-- /detail-col -->

        </div><!-- /product-body -->


        @if ($similarProducts->count())
            <div class="comparison-section" style="margin-top: 40px;">
                <h3>Compare with Similar Products</h3>
                <div class="comparison-table" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Overall Grade</th>
                                <th>Ingredient Grade</th>
                                <th>Defects Grade</th>
                                <th>Price</th>
                                <th>Test Date</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($similarProducts as $sim)
                                <tr>
                                    <td>
                                        <strong>{{ $sim->name }}</strong><br>
                                        <span style="font-size:0.9em;color:#888;">{{ $sim->brand->name ?? '' }}</span>
                                    </td>
                                    <td>{{ $sim->labTestingResult->overall_grade ?? 'N/A' }}</td>
                                    <td>{{ $sim->labTestingResult->ingredient_grade ?? 'N/A' }}</td>
                                    <td>{{ $sim->labTestingResult->defects_grade ?? 'N/A' }}</td>
                                    <td>
                                        @if ($sim->price)
                                            {{ $sim->currency }} {{ numberFormat($sim->price) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        {{ $sim->test_date ? $sim->test_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('products.show', $sim) }}"
                                            class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div><!-- /card-shell -->

    <!-- Image Modal -->
    <div class="modal-overlay" id="imageModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeImageModal()">&times;</button>
            <h3 style="margin: 0 0 16px 0; color: var(--text-dark);">{{ d_trans('All Product Images') }}</h3>
            <div class="modal-images-grid">
                @foreach ($productImageUrls as $imageUrl)
                    <div class="modal-image" onclick="selectPreviewFromModal(this, '{{ $imageUrl }}')">
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const imageUrls = {!! json_encode($productImageUrls->values()->all()) !!};

            function selectRoast(el) {
                document.querySelectorAll('.roast-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }

            function selectPreview(el, imageUrl) {
                const mainImage = document.getElementById('mainProductImage');
                if (mainImage) {
                    mainImage.src = imageUrl;
                }

                document.querySelectorAll('.img-thumb').forEach(t => t.classList.remove('active'));
                el.classList.add('active');
            }

            function openImageModal() {
                document.getElementById('imageModal').classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            function selectPreviewFromModal(el, imageUrl) {
                const mainImage = document.getElementById('mainProductImage');
                if (mainImage) {
                    mainImage.src = imageUrl;
                }
                closeImageModal();
            }

            // Close modal when clicking outside
            document.getElementById('imageModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeImageModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });
        </script>
    @endpush
@endsection
