@php
    $reviewer = $review->reviewer;
    $reviewBusiness = $review->business;
@endphp
<a href="{{ $review->getLink() }}" class="review box h-100">
    <div class="review-author">
        <div class="review-author-img">
            <img src="{{ $reviewer->avatar }}" alt="{{ $reviewer->name }}" />
        </div>
        <div class="review-author-info">
            <h6 class="review-author-title">{{ $reviewer->name }}</h6>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="ratings">
                    <img src="{{ $review->getRatingImageLink() }}" alt="{{ $review->stars }}" />
                </div>
            </div>
        </div>
    </div>
    <p class="review-text">{{ shorterText($review->trans->body, 200) }}</p>
    @if (isset($review_box_footer))
        <div class="review-item">
            <div class="item-sm d-flex align-items-center gap-3">
                <div class="item-img flex-shrink-0">
                    <img src="{{ $reviewBusiness->getLogoLink() }}" alt="{{ $reviewBusiness->trans->name }}">
                    @if ($reviewBusiness->isVerified())
                        <div class="item-verified">
                            <i class="bi bi-patch-check-fill" data-bs-toggle="tooltip"
                                data-bs-title="{{ d_trans('Verified') }}"></i>
                        </div>
                    @endif
                </div>
                <div class="item-info">
                    <h6 class="item-title text-truncate">{{ $reviewBusiness->trans->name }}</h6>
                    <p class="item-link small text-muted mb-0">{{ $reviewBusiness->domain }}</p>
                </div>
            </div>
        </div>
    @endif
</a>
