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
                font-family: 'Playfair Display', serif;
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
                width: 44%;
                flex-shrink: 0;
                background: var(--cream-dark);
                padding: 24px;
                display: flex;
                flex-direction: column;
                gap: 12px;
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
                font-family: 'Playfair Display', serif;
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
                font-family: 'Playfair Display', serif;
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

            /* Roast selector */
            .roast-grid {
                display: flex;
                gap: 12px;
                margin-bottom: 20px;
            }

            .roast-card {
                flex: 1;
                border: 1.5px solid var(--border);
                border-radius: 10px;
                padding: 10px 10px 8px;
                text-align: center;
                cursor: pointer;
                transition: border-color .25s ease, background .25s ease, box-shadow .25s ease, transform .25s ease;
                background: #f7f1e7;
            }

            .roast-card:hover {
                border-color: var(--tan);
                transform: translateY(-2px);
            }

            .roast-card.active {
                background: var(--selected-bg);
                border-color: var(--selected-border);
                box-shadow: 0 10px 20px rgba(30, 40, 32, 0.08);
            }

            .roast-img {
                width: 60px;
                height: 76px;
                margin: 0 auto 8px;
                border-radius: 6px;
                background: #efe8db;
                position: relative;
                overflow: hidden;
                border: 1px solid #d9cfbf;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .roast-img img {
                width: 100%;
                height: 100%;
                object-fit: contain;
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
                font-family: 'Playfair Display', serif;
                font-size: .85rem;
                font-weight: 500;
                color: var(--text-dark);
                margin-bottom: 2px;
            }

            .roast-sub {
                font-size: .62rem;
                color: var(--text-light);
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

        $roastImages = $productImageUrls->pad(3, $productImageUrls->first())->take(3)->values();
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

                <!-- Thumbnails -->
                <div class="img-thumbs">
                    @foreach ($productImageUrls->take(4) as $index => $imageUrl)
                        <button type="button" class="img-thumb {{ $index === 0 ? 'active' : '' }}"
                            onclick="selectPreview(this, '{{ $imageUrl }}')">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                        </button>
                    @endforeach
                </div>
            </div><!-- /img-col -->

            <!-- RIGHT: Product details -->
            <div class="detail-col">
                <p class="eyebrow">Your Everyday Reset</p>
                <h1 class="product-title">Daily Blend</h1>
                <div class="tags">
                    <span>Balanced</span>
                    <span class="dot"></span>
                    <span>Smooth</span>
                    <span class="dot"></span>
                    <span>Versatile</span>
                </div>

                <p class="product-desc">
                    Daily Blend is designed for quiet focus and gentle energy — the kind of coffee that supports your flow
                    without taking over. Whether it's work, journaling, or your second cup before noon, this one's your
                    go-to.
                </p>

                <!-- Roast selector -->
                <div class="roast-grid">
                    <div class="roast-card" onclick="selectRoast(this)">
                        <div class="roast-img">
                            <img src="{{ $roastImages[0] }}" alt="{{ $product->name }}">
                        </div>
                        <div class="roast-name">Calm</div>
                        <div class="roast-sub">Light Roast</div>
                    </div>
                    <div class="roast-card active" onclick="selectRoast(this)">
                        <div class="roast-img">
                            <img src="{{ $roastImages[1] }}" alt="{{ $product->name }}">
                        </div>
                        <div class="roast-name">Daily</div>
                        <div class="roast-sub">Medium Roast</div>
                    </div>
                    <div class="roast-card" onclick="selectRoast(this)">
                        <div class="roast-img">
                            <img src="{{ $roastImages[2] }}" alt="{{ $product->name }}">
                        </div>
                        <div class="roast-name">Bold</div>
                        <div class="roast-sub">Medium+Dark Roast</div>
                    </div>
                </div>

                <!-- Purchase options -->
                <div class="purchase-opts">
                    <div class="opt-row" onclick="selectOpt(this)">
                        <div class="opt-left">
                            <div class="radio-ring"></div>
                            <div class="opt-label">One time purchase <span>/ 250g</span></div>
                        </div>
                        <div class="opt-price">$22.00</div>
                    </div>
                    <div class="opt-row active" onclick="selectOpt(this)">
                        <div class="opt-left">
                            <div class="radio-ring"></div>
                            <div class="opt-label">Subscribe <span>/ 250g</span></div>
                        </div>
                        <div class="opt-price"><span class="original">$22.00</span> $19.80</div>
                    </div>
                </div>

                <!-- Frequency -->
                <select class="freq-select">
                    <option value="">Select delivery frequency</option>
                    <option>Every 2 weeks</option>
                    <option>Every 4 weeks</option>
                    <option>Every 6 weeks</option>
                    <option>Every 8 weeks</option>
                </select>

                <!-- Perks -->
                <div class="perks">
                    <div class="perk">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                            <rect x="2" y="7" width="20" height="14" rx="2" />
                            <path d="M16 7V5a2 2 0 00-4 0v2" />
                            <path d="M12 12v4" />
                        </svg>
                        Free shipping on
                    </div>
                    <div class="perk">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                            <path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.9L12 17.8l-6.2 3.3L7 14.2 2 9.3l6.9-1z" />
                        </svg>
                        Save 10%
                    </div>
                    <div class="perk">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                            <polyline points="23 4 23 10 17 10" />
                            <path d="M20.5 15a9 9 0 11-2.7-6.6L23 10" />
                        </svg>
                        Cancel or skip anytime
                    </div>
                </div>

                <!-- Add to cart -->
                <div class="cart-row">
                    <div class="qty-ctrl">
                        <button class="qty-btn" onclick="changeQty(-1)">−</button>
                        <span class="qty-num" id="qty">1</span>
                        <button class="qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                    <button class="btn-add">Add to cart</button>
                </div>
            </div><!-- /detail-col -->

        </div><!-- /product-body -->
    </div><!-- /card-shell -->
    @push('scripts')
        <script>
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

            function selectOpt(el) {
                document.querySelectorAll('.opt-row').forEach(r => r.classList.remove('active'));
                el.classList.add('active');
                const isSubscribe = el.querySelector('.opt-label').textContent.trim().startsWith('Subscribe');
                document.querySelector('.freq-select').style.display = isSubscribe ? 'block' : 'none';
                document.querySelector('.freq-select').style.display = isSubscribe ? '' : 'none';
            }

            function changeQty(delta) {
                const el = document.getElementById('qty');
                const val = Math.max(1, parseInt(el.textContent) + delta);
                el.textContent = val;
            }
        </script>
    @endpush
@endsection
