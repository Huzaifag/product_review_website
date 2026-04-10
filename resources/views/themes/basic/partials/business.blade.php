<div class="box item h-100 p-0 {{ $item_classes ?? '' }}">
    <a href="{{ $business->getLink() }}" class="item-body">
        <div class="d-flex align-items-start gap-3">
            <div class="item-img flex-shrink-0">
                <img loading="lazy" src="{{ $business->getLogoLink() }}" alt="{{ $business->trans->name }}" />
                @if ($business->isVerified())
                    <div class="item-verified">
                        <i class="bi bi-patch-check-fill" data-bs-toggle="tooltip"
                            data-bs-title="{{ d_trans('Verified') }}"></i>
                    </div>
                @endif
            </div>
            <div class="item-info">
                <h6 class="item-title text-truncate">{{ $business->trans->name }}</h6>
                <p class="item-link small text-muted mb-0">{{ $business->domain }}</p>
                <div class="d-flex align-items-center gap-1 flex-wrap mt-2">
                    <div class="ratings">
                        <img loading="lazy" src="{{ $business->getAvgRatingImageLink() }}"
                            alt="{{ $business->avg_ratings }}" />
                    </div>
                    <span class="ratings-text">
                        <b>{{ $business->avg_ratings }}</b><span
                            class="ms-1">({{ numberFormat($business->total_reviews) }})</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="item-text">
            <p class="mb-0">{{ $business->trans->short_description }}</p>
        </div>
    </a>
    @if (isset($item_footer) && $item_footer == true)
        <div class="item-footer">
            <div class="item-footer-title">
                <div class="item-footer-links">
                    <a href="{{ $business->website }}" target="_blank" class="item-footer-link">
                        <i class="fa-solid fa-globe"></i>
                    </a>
                    @if ($business->phone)
                        <a href="tel:{{ $business->phone }}" class="item-footer-link">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                    @endif
                    @if ($business->email)
                        <a href="mailto:{{ $business->email }}" class="item-footer-link">
                            <i class="fa-regular fa-envelope"></i>
                        </a>
                    @endif
                    @if ($business->hasAddressCompleted())
                        <a href="{{ $business->getGoogleMapAddress() }}" target="_blank" class="item-footer-link">
                            <i class="fa-solid fa-location-dot"></i>
                        </a>
                    @endif
                </div>
                @if ($business->hasCategory())
                    <div class="item-footer-text">
                        <span>{{ $business->category->trans->name }}</span>
                        @if ($business->first_categories)
                            <span>{{ $business->first_categories->subCategory->trans->name }}</span>
                            @foreach ($business->first_categories->subSubCategories as $subSub)
                                <span>{{ $subSub->trans->name }}</span>
                            @endforeach
                        @endif
                    </div>
                @endif
                @if ($business->total_reviews && $business->cached_reviews)
                    <a class="item-action ms-auto collapsed" data-bs-toggle="collapse"
                        href="#collapse{{ $business->id }}">
                        {{ d_trans('Latest reviews') }}<i class="bi bi-chevron-down ms-1"></i>
                    </a>
                @endif
            </div>
            @if ($business->total_reviews && $business->cached_reviews)
                <div class="item-collapse collapse" id="collapse{{ $business->id }}">
                    @foreach ($business->cached_reviews as $review)
                        <div class="swiper-slide h-auto">
                            @include('themes.basic.partials.review-box', ['review' => $review])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
