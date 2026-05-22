{{-- Shared product hero header — requires $product --}}
<div class="prod-hero mb-4">
    <div class="prod-hero-image">
        @if ($product->image)
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
        @else
            <div class="prod-hero-placeholder">
                <i class="fa-solid fa-box-open"></i>
            </div>
        @endif
    </div>
    <div class="prod-hero-info">
        <div class="d-flex align-items-start gap-3 flex-wrap">
            <div class="flex-grow-1">
                <h4 class="prod-hero-name">{{ d_trans($product->name ?? '') }}</h4>
                <span class="prod-hero-slug">{{ $product->slug }}</span>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                @if ($product->is_active)
                    <span class="prod-status-pill prod-status-active">
                        <i class="fa-solid fa-circle-check me-1"></i>{{ d_trans('Active') }}
                    </span>
                @else
                    <span class="prod-status-pill prod-status-inactive">
                        <i class="fa-solid fa-circle-xmark me-1"></i>{{ d_trans('Inactive') }}
                    </span>
                @endif
                @if ($product->is_featured)
                    <span class="prod-status-pill prod-status-featured">
                        <i class="fa-solid fa-star me-1"></i>{{ d_trans('Featured') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="prod-hero-meta mt-3">
            @if ($product->brand)
                <span class="prod-meta-chip"><i class="fa-solid fa-tag me-1"></i>{{ $product->brand->name }}</span>
            @endif
            @if ($product->category)
                <span class="prod-meta-chip"><i class="fa-solid fa-layer-group me-1"></i>{{ $product->category->trans->name ?? $product->category->name }}</span>
            @endif
            @if ($product->overall_grade)
                <span class="prod-meta-chip prod-meta-grade">
                    <i class="fa-solid fa-medal me-1"></i>{{ str_replace('_', ' ', ucfirst($product->overall_grade)) }}
                </span>
            @endif
        </div>
    </div>
</div>
