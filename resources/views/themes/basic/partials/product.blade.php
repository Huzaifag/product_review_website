@php
    $imagePath = $product->image ?: optional($product->images()->select('path')->first())->path;
    $imageSrc = $imagePath ? asset($imagePath) : asset(config('theme.settings.general.social_image'));
@endphp

<a href="{{ $product->getLink() }}" class="oko-card d-flex flex-column text-reset text-decoration-none h-100">

    {{-- Row 1: Image --}}
    <div class="oko-card__image-wrap">
        <img loading="lazy" src="{{ $imageSrc }}" alt="{{ d_trans($product->name) }}" class="oko-card__image">
    </div>

    {{-- Row 2: Name & Description --}}
    <div class="oko-card__body">
        <div class="oko-card__title-row">
            <h5 class="oko-card__title">{{ d_trans($product->name) }}</h5>
            @if ($product->oko_verified)
                <img src="{{ asset('images/oko/stamp-verification.webp') }}"
                     alt="OKO Verified"
                     class="oko-card__stamp">
            @endif
        </div>

        <div class="oko-card__meta">
            @if ($product->brand)
                <span class="oko-card__meta-item oko-card__meta-brand">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><rect x="1" y="2" width="8" height="6" rx="1.2" stroke="#9ca3af" stroke-width="1.1"/><path d="M3.5 2V1.5a1.5 1.5 0 013 0V2" stroke="#9ca3af" stroke-width="1.1" stroke-linecap="round"/></svg>
                    {{ $product->brand->name }}
                </span>
            @endif
            @if ($product->category)
                <span class="oko-card__meta-sep">·</span>
                <span class="oko-card__meta-item">
                    {{ $product->category->trans->name ?? $product->category->name }}
                </span>
            @endif
            @if ($product->subCategory)
                <span class="oko-card__meta-sep">·</span>
                <span class="oko-card__meta-item">
                    {{ $product->subCategory->trans->name ?? $product->subCategory->name }}
                </span>
            @endif
        </div>

        @if ($product->description)
            <p class="oko-card__desc">{{ d_trans($product->description) }}</p>
        @else
            <p class="oko-card__desc oko-card__desc--empty">&nbsp;</p>
        @endif
    </div>

    {{-- Row 3: Verification strip --}}
    {{-- <div class="oko-card__footer">
        @if ($product->oko_verified)
            <div class="oko-card__verify-box">
                <div>
                    <div class="oko-card__verify-title">{{ d_trans('OKO Verified') }}</div>
                    <div class="oko-card__verify-sub">{{ d_trans('Safety tested certification') }}</div>
                </div>
            </div>
        @else
            <div class="oko-card__verify-box oko-card__verify-box--none">
                <div>
                    <div class="oko-card__verify-title oko-card__verify-title--none">{{ d_trans('Not Yet Verified') }}</div>
                    <div class="oko-card__verify-sub">{{ d_trans('Pending OKO review') }}</div>
                </div>
            </div>
        @endif
    </div> --}}

</a>

@once
    @push('styles')
        <style>
            /* ─── Card shell ─────────────────────────────────────── */
            .oko-card {
                background: #fff;
                border: 1px solid rgba(0, 0, 0, 0.06);
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
                transition: transform 220ms ease, box-shadow 220ms ease;
                cursor: pointer;
            }

            .oko-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 22px 55px rgba(0, 0, 0, 0.10);
            }

            /* ─── Image area ─────────────────────────────────────── */
            .oko-card__image-wrap {
                position: relative;
                height: 250px;
                background: linear-gradient(180deg, #fafafa 0%, #f4f4f4 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
                flex-shrink: 0;
                overflow: hidden;
            }

            .oko-card__image {
                max-height: 200px;
                max-width: 78%;
                width: auto;
                object-fit: contain;
                filter: drop-shadow(0 18px 22px rgba(0, 0, 0, 0.10));
                transition: transform 280ms ease;
                display: block;
            }

            .oko-card:hover .oko-card__image {
                transform: scale(1.04);
            }

            /* ─── Title row + stamp ──────────────────────────────── */
            .oko-card__title-row {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 0;
            }

            .oko-card__title-row .oko-card__title {
                flex: 1;
                margin-bottom: 0;
            }

            .oko-card__stamp {
                width: 72px;
                height: auto;
                flex-shrink: 0;
                object-fit: contain;
                margin-top: 2px;
                pointer-events: none;
            }

            /* ─── Body ───────────────────────────────────────────── */
            .oko-card__body {
                flex: 1;
                padding: 22px 22px 16px;
            }

            .oko-card__title {
                font-size: 16px;
                font-weight: 700;
                line-height: 1.35;
                color: #111827;
                letter-spacing: -0.02em;
                margin: 0 0 10px;
                min-height: 44px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* ─── Meta row ───────────────────────────────────────── */
            .oko-card__meta {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 4px;
                margin-bottom: 10px;
            }

            .oko-card__meta-item {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-size: 11.5px;
                color: #9ca3af;
                font-weight: 500;
                white-space: nowrap;
            }

            .oko-card__meta-brand {
                color: #6b7280;
                font-weight: 600;
            }

            .oko-card__meta-sep {
                font-size: 11px;
                color: #d1d5db;
                line-height: 1;
            }

            .oko-card__desc {
                font-size: 13.5px;
                line-height: 1.6;
                color: #6b7280;
                margin: 0;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .oko-card__desc--empty {
                min-height: 44px;
            }

            /* ─── Footer / verification strip ────────────────────── */
            .oko-card__footer {
                padding: 0 18px 18px;
            }

            .oko-card__verify-box {
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 14px 16px;
                border-radius: 14px;
                background: #fff7f7;
                border: 1px solid rgba(198, 40, 40, 0.15);
            }

            .oko-card__verify-box--none {
                background: #f9fafb;
                border-color: rgba(0, 0, 0, 0.07);
            }

            .oko-card__verify-logo {
                width: 160px;
                height: auto;
                flex-shrink: 0;
                object-fit: contain;
            }

            .oko-card__verify-dot {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #e5e7eb;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .oko-card__verify-title {
                font-size: 11.5px;
                font-weight: 800;
                color: #9f1d1d;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                line-height: 1.2;
            }

            .oko-card__verify-title--none {
                color: #6b7280;
            }

            .oko-card__verify-sub {
                margin-top: 3px;
                font-size: 11.5px;
                color: #7c2d2d;
                line-height: 1.3;
            }

            .oko-card__verify-box--none .oko-card__verify-sub {
                color: #9ca3af;
            }
        </style>
    @endpush
@endonce
