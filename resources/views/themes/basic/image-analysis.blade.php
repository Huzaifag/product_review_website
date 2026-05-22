@extends('themes.basic.layouts.app')
@section('title', d_trans('Image Analysis Results'))
@section('content')
    <section class="oeko-image-analysis">
        <div class="oeko-image-analysis-inner">
            <div class="oeko-image-analysis-header">
                <div class="oeko-header-text">
                    {{-- <span class="oeko-header-eyebrow">{{ d_trans('AI Powered') }}</span> --}}
                    <h1>{{ d_trans('Image Analysis Results') }}</h1>
                </div>
                <a href="{{ route('home') }}" class="oeko-analysis-back">
                    <span class="oeko-back-icon" aria-hidden="true">&#8592;</span>
                    {{ d_trans('Upload another image') }}
                </a>
            </div>

            <div class="oeko-image-analysis-grid">
                <div class="oeko-analysis-card">
                    <h2>{{ d_trans('Uploaded Image') }}</h2>
                    <div class="oeko-analysis-image">
                        <img src="{{ $imageUrl }}" alt="{{ d_trans('Uploaded product image') }}">
                    </div>
                </div>

                @if ($exactProduct)
                    <div class="oeko-analysis-card oeko-exact-product">
                        <span class="oeko-exact-badge">{{ d_trans('Exact Match') }}</span>

                        <div class="oeko-exact-content">

                            <div>
                                <p class="oeko-exact-title">{{ d_trans($exactProduct->name) }}</p>
                                <p class="oeko-exact-meta">
                                    {{ d_trans(optional($exactProduct->category)->name) }}
                                    @if ($exactProduct->subCategory)
                                        • {{ d_trans($exactProduct->subCategory->name) }}
                                    @endif
                                </p>
                                @if ($exactProduct->brand)
                                    <p class="oeko-exact-meta">{{ d_trans($exactProduct->brand->name) }}</p>
                                @endif
                                @if ($exactProduct->description)
                                    <p class="oeko-exact-description">{{ d_trans($exactProduct->description) }}</p>
                                @endif
                                <dl class="oeko-analysis-list" style="margin-top:12px;">
                                    @if ($exactProduct->product_size)
                                        <div class="oeko-analysis-row">
                                            <dt>{{ d_trans('Size') }}</dt>
                                            <dd>{{ $exactProduct->product_size }}</dd>
                                        </div>
                                    @endif
                                    @if (!is_null($exactProduct->price))
                                        <div class="oeko-analysis-row">
                                            <dt>{{ d_trans('Price') }}</dt>
                                            <dd>{{ $exactProduct->price }} {{ $exactProduct->currency }}</dd>
                                        </div>
                                    @endif
                                    @if (!is_null($exactProduct->overall_grade))
                                        <div class="oeko-analysis-row">
                                            <dt>{{ d_trans('Grade') }}</dt>
                                            <dd>{{ d_trans(\Illuminate\Support\Str::of($exactProduct->overall_grade)->replace('_', ' ')->title()) }}</dd>
                                        </div>
                                    @endif
                                    @if (!is_null($exactProduct->lab_verified))
                                        <div class="oeko-analysis-row">
                                            <dt>{{ d_trans('Lab Verified') }}</dt>
                                            <dd>{{ $exactProduct->lab_verified ? d_trans('Yes') : d_trans('No') }}</dd>
                                        </div>
                                    @endif
                                    @if ($exactProduct->test_year)
                                        <div class="oeko-analysis-row">
                                            <dt>{{ d_trans('Test Year') }}</dt>
                                            <dd>{{ $exactProduct->test_year }}</dd>
                                        </div>
                                    @endif
                                    @if ($exactProduct->test_edition)
                                        <div class="oeko-analysis-row">
                                            <dt>{{ d_trans('Test Edition') }}</dt>
                                            <dd>{{ $exactProduct->test_edition }}</dd>
                                        </div>
                                    @endif
                                    @if ($exactProduct->magazine_page)
                                        <div class="oeko-analysis-row">
                                            <dt>{{ d_trans('Magazine Page') }}</dt>
                                            <dd>{{ $exactProduct->magazine_page }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        </div>

                        <div class="oeko-exact-footer">
                            <a class="oeko-exact-button" href="{{ $exactProduct->getLink() }}">
                                {{ d_trans('View Details') }}
                                <span class="oeko-exact-button-icon" aria-hidden="true">&#8594;</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="oeko-analysis-card">
                        <h2>{{ d_trans('Generated Insights') }}</h2>
                        <dl class="oeko-analysis-list">
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Product') }}</dt>
                                <dd>{{ $analysis['product_name'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Category') }}</dt>
                                <dd>{{ $analysis['category'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Subcategory') }}</dt>
                                <dd>{{ $analysis['subcategory'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Matched Category') }}</dt>
                                <dd>{{ $analysis['matched_category'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Matched Subcategory') }}</dt>
                                <dd>{{ $analysis['matched_subcategory'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Brand') }}</dt>
                                <dd>{{ $analysis['brand'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Product Size') }}</dt>
                                <dd>{{ $analysis['product_size'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Price') }}</dt>
                                <dd>{{ $analysis['price'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Color') }}</dt>
                                <dd>{{ $analysis['color'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Material') }}</dt>
                                <dd>{{ $analysis['material'] ?? '-' }}</dd>
                            </div>
                            <div class="oeko-analysis-row">
                                <dt>{{ d_trans('Confidence') }}</dt>
                                <dd>
                                    @if (isset($analysis['confidence']))
                                        <span class="oeko-confidence-pill">{{ $analysis['confidence'] }}%</span>
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                            <div class="oeko-analysis-row oeko-analysis-row--full">
                                <dt>{{ d_trans('Description') }}</dt>
                                <dd>{{ $analysis['description'] ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                @endif
            </div>

            <div class="oeko-analysis-card oeko-matched-card">
                <h2>{{ d_trans('Matched Products') }}</h2>

                @if ($matchedProducts->isNotEmpty())
                    <p class="oeko-analysis-hint">
                        <span class="oeko-hint-dot" aria-hidden="true"></span>
                        {{ d_trans('Exact matches from the subcategory.') }}
                    </p>
                    <div class="oeko-analysis-products">
                        @foreach ($matchedProducts as $product)
                            <a class="oeko-analysis-product" href="{{ $product->getLink() }}">
                                <div class="oeko-analysis-product-thumb">
                                    <img src="{{ $product->getImageLink() }}" alt="{{ $product->name }}">
                                </div>
                                <div class="oeko-analysis-product-body">
                                    <p class="oeko-analysis-product-title">{{ d_trans($product->name) }}</p>
                                    <p class="oeko-analysis-product-meta">
                                        {{ optional($product->category)->name }}
                                        @if ($product->subCategory)
                                            • {{ $product->subCategory->name }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($categoryProducts->isNotEmpty())
                    <p class="oeko-analysis-hint">
                        <span class="oeko-hint-dot" aria-hidden="true"></span>
                        {{ d_trans('More results from the same category.') }}
                    </p>
                    <div class="oeko-analysis-products">
                        @foreach ($categoryProducts as $product)
                            <a class="oeko-analysis-product" href="{{ $product->getLink() }}">
                                <div class="oeko-analysis-product-thumb">
                                    <img src="{{ $product->getImageLink() }}" alt="{{ $product->name }}">
                                </div>
                                <div class="oeko-analysis-product-body">
                                    <p class="oeko-analysis-product-title">{{ d_trans($product->name) }}</p>
                                    <p class="oeko-analysis-product-meta">
                                        {{ d_trans(optional($product->category)->name) }}
                                        @if ($product->subCategory)
                                            • {{ d_trans($product->subCategory->name) }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($brandProducts->isNotEmpty())
                    <p class="oeko-analysis-hint">
                        <span class="oeko-hint-dot" aria-hidden="true"></span>
                        {{ d_trans('More results from the same brand.') }}
                    </p>
                    <div class="oeko-analysis-products">
                        @foreach ($brandProducts as $product)
                            <a class="oeko-analysis-product" href="{{ $product->getLink() }}">
                                <div class="oeko-analysis-product-thumb">
                                    <img src="{{ $product->getImageLink() }}" alt="{{ $product->name }}">
                                </div>
                                <div class="oeko-analysis-product-body">
                                    <p class="oeko-analysis-product-title">{{ d_trans($product->name) }}</p>
                                    <p class="oeko-analysis-product-meta">
                                        {{ d_trans(optional($product->category)->name) }}
                                        @if ($product->subCategory)
                                            • {{ d_trans($product->subCategory->name) }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($matchedProducts->isEmpty() && $categoryProducts->isEmpty() && $brandProducts->isEmpty())
                    <div class="oeko-analysis-empty">
                        <p class="oeko-analysis-hint">
                            {{ d_trans('No matching products were found. Please review the AI response above or try another image.') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .oeko-image-analysis {
            background:
                radial-gradient(1200px 500px at 85% -10%, rgba(198, 40, 40, 0.06), transparent 60%),
                radial-gradient(900px 400px at 10% 0%, rgba(237, 224, 212, 0.55), transparent 55%),
                #FDF8F4;
            padding: 60px 0 90px;
        }

        .oeko-image-analysis-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .oeko-image-analysis-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid #EDE0D4;
        }

        .oeko-header-text {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .oeko-header-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #C62828;
            background: rgba(198, 40, 40, 0.08);
            border: 1px solid rgba(198, 40, 40, 0.16);
            padding: 5px 12px;
            border-radius: 999px;
            width: fit-content;
        }

        .oeko-image-analysis-header h1 {
            font-size: clamp(28px, 3vw, 42px);
            color: #2C1A0E;
            margin: 0;
            line-height: 1.1;
            letter-spacing: -0.01em;
        }

        .oeko-analysis-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #C62828;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 999px;
            border: 1px solid rgba(198, 40, 40, 0.22);
            background: #FFFFFF;
            box-shadow: 0 6px 16px rgba(198, 40, 40, 0.10);
            transition: transform 160ms ease, box-shadow 160ms ease, background 160ms ease;
            white-space: nowrap;
        }

        .oeko-analysis-back:hover {
            transform: translateY(-1px);
            background: #C62828;
            color: #FFFFFF;
            box-shadow: 0 10px 22px rgba(198, 40, 40, 0.26);
        }

        .oeko-back-icon {
            font-size: 16px;
            line-height: 1;
            transition: transform 160ms ease;
        }

        .oeko-analysis-back:hover .oeko-back-icon {
            transform: translateX(-3px);
        }

        .oeko-image-analysis-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        .oeko-analysis-card {
            position: relative;
            background:
                linear-gradient(180deg, #FFFFFF 0%, #FFFDFB 100%);
            border-radius: 22px;
            padding: 24px;
            border: 1px solid #EDE0D4;
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.8) inset,
                0 18px 40px rgba(44, 26, 14, 0.09),
                0 4px 10px rgba(44, 26, 14, 0.04);
            transition: box-shadow 220ms ease, transform 220ms ease;
        }

        .oeko-analysis-card:hover {
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.8) inset,
                0 24px 50px rgba(44, 26, 14, 0.13),
                0 6px 14px rgba(44, 26, 14, 0.06);
        }

        .oeko-exact-product {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .oeko-exact-product::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #C62828, #E36A4A);
            border-top-left-radius: 22px;
            border-top-right-radius: 22px;
        }

        .oeko-exact-badge {
            align-self: flex-start;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #C62828;
            background: rgba(198, 40, 40, 0.08);
            border: 1px solid rgba(198, 40, 40, 0.18);
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 18px;
        }

        .oeko-exact-content {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            flex: 1;
        }

        .oeko-exact-content img {
            width: 90px;
            height: 90px;
            border-radius: 16px;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid #EDE0D4;
        }

        .oeko-exact-title {
            font-size: 18px;
            font-weight: 700;
            color: #2C1A0E;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }

        .oeko-exact-meta {
            font-size: 12px;
            color: #9C8878;
            margin: 0 0 6px 0;
        }

        .oeko-exact-description {
            font-size: 13px;
            line-height: 1.6;
            color: #4A3728;
            margin: 12px 0 16px 0;
        }


        .oeko-exact-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #F0E2D6;
        }

        .oeko-exact-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #C62828;
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 600;
            padding: 11px 22px;
            border-radius: 999px;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(198, 40, 40, 0.26);
            transition: transform 160ms ease, box-shadow 160ms ease, background 160ms ease;
        }

        .oeko-exact-button:hover {
            transform: translateY(-2px);
            background: #B71F1F;
            box-shadow: 0 12px 26px rgba(198, 40, 40, 0.34);
            color: #FFFFFF;
        }

        .oeko-exact-button-icon {
            font-size: 15px;
            line-height: 1;
            transition: transform 160ms ease;
        }

        .oeko-exact-button:hover .oeko-exact-button-icon {
            transform: translateX(3px);
        }

        .oeko-analysis-card h2 {
            font-size: 20px;
            font-weight: 700;
            color: #2C1A0E;
            margin: 0 0 18px 0;
            padding-bottom: 14px;
            border-bottom: 1px solid #F0E2D6;
        }

        .oeko-analysis-image {
            /* background:
                radial-gradient(circle at 50% 30%, #FFFFFF, #FFF7F1); */
            /* border-radius: 18px; */
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 280px;
            /* border: 1px solid #F0E2D6; */
        }

        .oeko-analysis-image img {
            max-width: 100%;
            max-height: 340px;
            object-fit: contain;
            border-radius: 12px;
            /* box-shadow: 0 12px 28px rgba(44, 26, 14, 0.12); */
        }

        .oeko-analysis-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .oeko-analysis-row {
            display: flex;
            align-items: baseline;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #F0E2D6;
        }

        .oeko-analysis-row:last-child {
            border-bottom: none;
        }

        .oeko-analysis-row--full {
            align-items: flex-start;
        }

        .oeko-analysis-row dt {
            flex-shrink: 0;
            width: 140px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #9C8878;
        }

        .oeko-analysis-row dd {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            color: #2C1A0E;
            line-height: 1.5;
        }

        .oeko-confidence-pill {
            display: inline-block !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            text-transform: none !important;
            letter-spacing: 0 !important;
            color: #C62828 !important;
            background: rgba(198, 40, 40, 0.10);
            border: 1px solid rgba(198, 40, 40, 0.20);
            padding: 3px 10px;
            border-radius: 999px;
            margin: 0 !important;
        }


        .oeko-matched-card {
            padding-top: 24px;
        }

        .oeko-analysis-hint {
            display: flex;
            align-items: center;
            gap: 10px;
            
            font-size: 14px;
            font-weight: 600;
            color: #6D5344;
            margin: 28px 0 18px 0;
        }

        .oeko-analysis-hint:first-of-type {
            margin-top: 0;
        }

        .oeko-hint-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #C62828;
            box-shadow: 0 0 0 4px rgba(198, 40, 40, 0.12);
            flex-shrink: 0;
        }

        .oeko-analysis-products {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .oeko-analysis-product {
            display: flex;
            gap: 14px;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid #EDE0D4;
            background: linear-gradient(180deg, #FFFFFF, #FFFDFB);
            box-shadow: 0 8px 18px rgba(44, 26, 14, 0.06);
            text-decoration: none;
            color: inherit;
            transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease;
        }

        .oeko-analysis-product:hover {
            transform: translateY(-3px);
            border-color: #E5D2C2;
            box-shadow: 0 16px 30px rgba(44, 26, 14, 0.14);
        }

        .oeko-analysis-product-thumb {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid #F0E2D6;
            background: #FFF7F1;
        }

        .oeko-analysis-product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 220ms ease;
        }

        .oeko-analysis-product:hover .oeko-analysis-product-thumb img {
            transform: scale(1.06);
        }

        .oeko-analysis-product-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        .oeko-analysis-product-title {
            font-size: 13px;
            font-weight: 700;
            color: #2C1A0E;
            margin: 0 0 6px 0;
            line-height: 1.35;
        }

        .oeko-analysis-product-meta {
            font-size: 11px;
            color: #9C8878;
            margin: 0;
        }

        .oeko-analysis-empty {
            text-align: center;
            padding: 32px 20px;
            background: #FFF7F1;
            border: 1px dashed #E5D2C2;
            border-radius: 16px;
        }

        .oeko-analysis-empty .oeko-analysis-hint {
            justify-content: center;
            margin: 0;
            color: #9C8878;
            font-weight: 500;
        }

        @media (max-width: 900px) {
            .oeko-image-analysis-grid {
                grid-template-columns: 1fr;
            }

            .oeko-analysis-products {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .oeko-image-analysis-header {
                flex-direction: column;
                align-items: flex-start;
            }


            .oeko-analysis-products {
                grid-template-columns: 1fr;
            }

            .oeko-exact-content {
                flex-direction: column;
                align-items: flex-start;
            }


            .oeko-exact-footer {
                justify-content: stretch;
            }

            .oeko-exact-button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush
