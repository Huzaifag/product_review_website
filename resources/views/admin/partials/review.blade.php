@php
    $reviewUser = $review->user;
    $reviewProduct = $review->product;
@endphp
<div class="item-review">
    @if (isset($review_header) && $reviewProduct)
        <p class="text-muted mb-2">
            {!! d_trans('Review of :product_name', [
                'product_name' =>
                    '<a href="' .
                    $reviewProduct->getLink() .
                    '" class="text-decoration-underline">' .
                    $reviewProduct->name .
                    '</a>',
            ]) !!}
        </p>
    @endif
    <div class="box">
        <div class="item-review-header">
            <div class="row align-items-center g-3">
                <div class="col">
                    <div class="user gap-3">
                        <span class="user-avatar user-avatar-md">
                            <img src="{{ $reviewUser?->getAvatar() ?? asset(config('theme.settings.general.social_image')) }}"
                                alt="{{ $reviewUser?->getName() ?? d_trans('User') }}" />
                        </span>
                        <div class="user-info">
                            <div class="fw-medium">
                                <span>{{ $reviewUser?->getName() ?? d_trans('Anonymous') }}</span>
                            </div>
                            <time class="text-muted small">{{ $review->created_at->diffforhumans() }}</time>
                        </div>
                    </div>
                </div>
                @if ($reviewProduct)
                    <div class="col-auto text-muted small">
                        <a href="{{ $reviewProduct->getLink() }}" class="text-decoration-underline">
                            {{ $reviewProduct->name }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="item-review-body">
            @if ($review->title)
                <h5 class="item-review-title">{{ $review->title }}</h5>
            @endif
            <p class="item-review-text">{!! purifier($review->body) !!}</p>
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg">
                    <div class="ratings ratings-lg">
                        {!! $review->renderStars() !!}
                    </div>
                </div>
                <div class="col-12 col-lg-auto">
                    <h6>{{ d_trans('Submitted') }}:
                        <span class="fw-light">{{ dateFormat($review->created_at, 'M d, Y') }}</span>
                    </h6>
                </div>
            </div>
        </div>
        <div class="item-review-footer">
            <div class="item-review-actions">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">
                        {{ $review->helpful_count ?? 0 }}
                        {{ d_trans('people found this useful') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
