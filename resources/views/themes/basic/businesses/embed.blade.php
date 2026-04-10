<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-bootstrap />
    @themeColors
    <link rel="stylesheet" href="{{ theme_asset_with_version('assets/css/widgets.css') }}">
    <script>
        "use strict";
        if (window.top === window.self) {
            window.location.href = "{{ $business->getLink() }}";
        }
    </script>
</head>

<body>
    @if (request()->input('v') == 2)
        <div class="card widget p-3">
            <a href="{{ $business->getLink() }}" target="_blank">
                <div class="d-flex align-items-center mb-3">
                    <img loading="lazy" src="{{ asset(config('theme.settings.general.logo_dark')) }}"
                        alt="{{ $business->trans->name }}" class="widget-v2-logo">
                    <span class="widget-v2-title text-truncate">{{ $business->trans->name }}</span>
                </div>
            </a>
            <div class="d-flex align-items-center mb-2">
                <img loading="lazy" src="{{ $business->getAvgRatingImageLink() }}" alt="{{ $business->avg_ratings }}"
                    class="widget-v2-rating-img">
                <span class="widget-v2-rating">
                    <strong class="widget-rating">{{ $business->avg_ratings }}</strong>
                    ({{ translate_choice(':count Review|:count Reviews', $business->total_reviews, ['count' => numberFormat($business->total_reviews)]) }})
                </span>
            </div>
            <a href="{{ $business->getWriteReviewLink() }}" target="_blank" class="widget-v2-link text-end"
                rel="noopener noreferrer">
                {{ d_trans('Write a review') }}
            </a>
        </div>
    @elseif (request()->input('v') == 3)
        @php
            $reviewStats = $business->getReviewStarStats();
        @endphp
        <div class="card widget p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="{{ $business->getLink() }}" target="_blank">
                    <img loading="lazy" src="{{ asset(config('theme.settings.general.logo_dark')) }}"
                        alt="{{ m_trans(config('settings.general.site_name')) }}" class="widget-v3-logo">
                </a>
                <img loading="lazy" src="{{ $business->getAvgRatingImageLink() }}" alt="{{ $business->avg_ratings }}"
                    class="widget-v3-rating-img">
            </div>
            <h6 class="widget-v3-title text-truncate mb-1">{{ $business->trans->name }}</h6>
            <div class="widget-average mb-3">
                {{ d_trans('Average Rating') }}<strong class="widget-rating">{{ $business->avg_ratings }}</strong> |
                <a href="{{ $business->getLink() }}" target="_blank" class="widget-reviews-link">
                    {{ translate_choice(':count Review|:count Reviews', $business->total_reviews, ['count' => numberFormat($business->total_reviews)]) }}
                </a>
            </div>
            @foreach ([5, 4, 3, 2, 1] as $star)
                <div class="d-flex align-items-center mb-2">
                    <span class="widget-v3-star-label">{{ d_trans(':number Star', ['number' => $star]) }}</span>
                    <div class="progress flex-grow-1 mx-2 widget-v3-progress-bg">
                        <div class="progress-bar widget-v3-progress-bar" role="progressbar"
                            style="width: {{ $reviewStats['percentages'][$star] ?? 0 }}%;"
                            aria-valuenow="{{ $reviewStats['percentages'][$star] ?? 0 }}" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                    <span class="widget-v3-star-count">{{ $reviewStats['percentages'][$star] ?? 0 }}%</span>
                </div>
            @endforeach
            <div class="text-end mt-3">
                <a href="{{ $business->getWriteReviewLink() }}" target="_blank" class="widget-v3-link"
                    rel="noopener noreferrer">
                    {{ d_trans('Write a review') }}
                </a>
            </div>
        </div>
    @elseif (request()->input('v') == 4)
        <div class="card widget p-4 text-center">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <a href="{{ $business->getLink() }}" target="_blank">
                    <img loading="lazy" src="{{ asset(config('theme.settings.general.logo_dark')) }}"
                        alt="{{ m_trans(config('settings.general.site_name')) }}" class="widget-v4-logo">
                </a>
            </div>
            <div class="widget-v4-title text-truncate mb-2">{{ $business->trans->name }}</div>
            <div class="widget-v4-rating mb-2">
                <img loading="lazy" src="{{ $business->getAvgRatingImageLink() }}" alt="Rating"
                    class="widget-v4-rating-img">
            </div>
            <div class="widget-average mb-2">
                {{ d_trans('Average Rating') }}<strong class="widget-rating">{{ $business->avg_ratings }}</strong> |
                <a href="{{ $business->getLink() }}" target="_blank" class="widget-reviews-link">
                    {{ translate_choice(':count Review|:count Reviews', $business->total_reviews, ['count' => numberFormat($business->total_reviews)]) }}
                </a>
            </div>
            <div class="widget-v4-link">
                <a href="{{ $business->getWriteReviewLink() }}" target="_blank"
                    class="btn btn-primary text-white w-100">{{ d_trans('Write a review') }}</a>
            </div>
        </div>
    @else
        <div class="widget-v1">
            <a href="{{ $business->getLink() }}" target="_blank">
                <img loading="lazy" src="{{ asset(config('theme.settings.general.logo_dark')) }}"
                    alt="{{ m_trans(config('settings.general.site_name')) }}" class="widget-v1-logo">
                <img loading="lazy" src="{{ $business->getAvgRatingImageLink() }}" alt="{{ $business->avg_ratings }}"
                    class="widget-v1-rating-image">
            </a>
            <div class="widget-average">
                {{ d_trans('Average Rating') }}<strong class="widget-rating">{{ $business->avg_ratings }}</strong> |
                <a href="{{ $business->getLink() }}" target="_blank" class="widget-reviews-link">
                    {{ translate_choice(':count Review|:count Reviews', $business->total_reviews, ['count' => numberFormat($business->total_reviews)]) }}
                </a>
            </div>
        </div>
    @endif
</body>

</html>
