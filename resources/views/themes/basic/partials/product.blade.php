<div class="col" data-aos="fade-up" data-aos-duration="1000">
    <a href="{{ $product->getLink() }}" class="featured-lab-card d-block text-reset text-decoration-none">
        {{-- <i class="fa-solid fa-box-open featured-lab-corner-icon"></i> --}}

        <div class="featured-lab-head">
            <div class="featured-lab-thumb">
                <img loading="lazy" src="{{ $product->getImageLink() }}" alt="{{ $product->name }}">
            </div>
            <div class="featured-lab-head-copy">
                <span class="featured-lab-kicker">
                    <i class="bi bi-bag-check"></i>{{ d_trans('Featured Product') }}
                </span>
                <h5 class="featured-lab-title">
                    {{ \Illuminate\Support\Str::limit($product->name, 42) }}</h5>
                <p class="featured-lab-description">
                    {{ \Illuminate\Support\Str::limit($product->brand_name . ($product->description ? ' • ' . $product->description : ''), 112) }}
                </p>
            </div>
        </div>

        <div class="featured-lab-chips">
            <span class="featured-lab-index featured-lab-index-category">
                <i class="bi bi-tag"></i>
                {{ $product->category->trans->name ?? d_trans('Uncategorized') }}
            </span>
            @if ($product->subCategory)
                <span class="featured-lab-index featured-lab-index-subcategory">
                    <i class="bi bi-tag"></i>
                    {{ $product->subCategory->trans->name ?? $product->subCategory->name }}
                </span>
            @endif
            @if ($product->product_size)
                <span class="featured-lab-index">
                    <i class="bi bi-rulers"></i>
                    {{ $product->product_size }}
                </span>
            @endif
            @if ($product->price)
                {{-- <span class="featured-lab-index featured-lab-index-price">
                                                <i class="bi bi-cash-coin"></i>
                                                {{ $product->currency }} {{ numberFormat($product->price) }}
                                            </span> --}}
            @endif
        </div>

        <div class="featured-lab-expand">
            <div class="featured-lab-expand-inner">
                <div class="featured-lab-meta-item">
                    <span>{{ d_trans('Brand') }}</span>
                    <strong>{{ $product->brand_name }}</strong>
                </div>
                <div class="featured-lab-meta-item">
                    <span>{{ d_trans('Organic Certified') }}</span>
                    <strong>{{ $product->organic_certified ? d_trans('Yes') : d_trans('No') }}</strong>
                </div>
                @if ($product->price)
                    <div class="featured-lab-meta-item featured-lab-meta-price">
                        <span>{{ d_trans('Price') }}</span>
                        <strong>{{ $product->currency }} {{ numberFormat($product->price) }}</strong>
                    </div>
                @endif
                <div class="featured-lab-meta-item">
                    <span>{{ d_trans('Ingredients') }}</span>
                    <strong>{{ count($product->getIngredientsList()) }}</strong>
                </div>
                @if ($product->getIngredientsList())
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @foreach ($product->getIngredientsList() as $ingredient)
                            <span class="featured-lab-chip featured-lab-chip-safe">{{ $ingredient }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <span class="featured-lab-hint">
            <i class="bi bi-chevron-down"></i>
        </span>
    </a>
</div>
