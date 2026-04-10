<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
    <x-ad alias="head_code" />
</head>

<body class="bg-custom">
    @include('themes.basic.includes.navbar')
    <header class="header header-sm">
        <div class="container @yield('container') d-flex flex-column flex-grow-1">
            <div class="header-inner text-start py-4">
                @yield('breadcrumbs')
                <div class="py-3 text-center text-xl-start">
                    <div
                        class="row row-cols-1 row-cols-xl-auto align-items-center flex-xl-nowrap justify-content-between g-3">
                        <div class="col flex-shrink-1 flex-grow-1">
                            <div class="item-lg d-flex align-items-center flex-column flex-sm-row">
                                <div
                                    class="row align-items-center row-cols-1 row-cols-xl-auto flex-xl-nowrap gx-4 gy-3 flex-grow-1">
                                    <div class="col">
                                        <div class="item-img mx-auto">
                                            <a href="{{ $business->getLink() }}">
                                                <img src="{{ $business->getLogoLink() }}"
                                                    alt="{{ $business->trans->name }}">
                                            </a>
                                            @if ($business->isVerified())
                                                <div class="item-verified">
                                                    <i class="bi bi-patch-check-fill" data-bs-toggle="tooltip"
                                                        data-bs-title="{{ d_trans('Verified') }}"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col flex-shrink-1">
                                        <div class="item-info">
                                            <h1 class="item-title">
                                                <a href="{{ $business->getLink() }}">
                                                    {{ $business->trans->name }}
                                                </a>
                                            </h1>
                                            <div
                                                class="d-flex align-items-center justify-content-center justify-content-xl-start gap-2 flex-wrap">
                                                <div class="ratings ratings-xl">
                                                    <img src="{{ $business->getAvgRatingImageLink() }}"
                                                        alt="{{ $business->avg_ratings }}" />
                                                </div>
                                            </div>
                                            <div class="item-meta mt-2">
                                                <i class="bi bi-star-fill"></i>
                                                <span>
                                                    {{ translate_choice(
                                                        ':avg_ratings from :total_reviews Review and Rating|:avg_ratings from :total_reviews Reviews and Ratings',
                                                        $business->total_reviews,
                                                        [
                                                            'avg_ratings' => $business->avg_ratings,
                                                            'total_reviews' => numberFormat($business->total_reviews),
                                                        ],
                                                    ) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-wrap justify-content-center justify-content-xl-start  mt-2 gap-2">
                                            @if ($business->isClaimed())
                                                <div class="tooltip-badge"
                                                    data-arrow="{{ getDirection() == 'rtl' ? 'right' : 'left' }}">
                                                    <div class="tooltip-hover">
                                                        <i
                                                            class="bi bi-check2-circle text-success me-2"></i><span>{{ d_trans('Claimed Profile') }}</span>
                                                    </div>
                                                    <div class="tooltip-content">
                                                        <div>
                                                            <h6 class="mb-2">
                                                                {{ d_trans('Business profile has been claimed') }}</h6>
                                                            <p class="mb-0">
                                                                {{ d_trans('This business has claimed their profile on our platform. Claimed profiles gain trust by showing authenticity, allowing them to respond to customer reviews and highlight verified information.') }}n
                                                            </p>
                                                        </div>
                                                        <div class="mt-3 pt-3 border-top">
                                                            <h6 class="mb-2">{{ d_trans('Verified details') }}</h6>
                                                            <p class="mb-2">
                                                                {{ d_trans('The details that have been provided so far by the business to verify their profile.') }}
                                                            </p>
                                                            <ul class="list-unstyled tool-tip-checklist mb-0">
                                                                @php
                                                                    $detailsCompleted =
                                                                        $business->hasDetailsCompleted() &&
                                                                        $business->hasLogoCompleted() &&
                                                                        $business->hasAddressCompleted() &&
                                                                        $business->hasSocialLinksCompleted();
                                                                    $businessOwner = $business->owner;
                                                                @endphp
                                                                <li class="d-flex align-items-center gap-1">
                                                                    <span
                                                                        class="tool-tip-cross-icon {{ $detailsCompleted ? 'tool-tip-check-icon' : 'tool-tip-times-icon' }}  me-2">
                                                                        <i
                                                                            class="fa {{ $detailsCompleted ? 'fa-check' : 'fa-x' }}  small"></i>
                                                                    </span>{{ d_trans('Business details provided') }}
                                                                </li>
                                                                @if (config('settings.kyc.actions.status'))
                                                                    <li class="d-flex align-items-center gap-1">
                                                                        <span
                                                                            class="tool-tip-cross-icon {{ $businessOwner->hasKycVerified() ? 'tool-tip-check-icon' : 'tool-tip-times-icon' }} me-2">
                                                                            <i
                                                                                class="fa {{ $businessOwner->hasKycVerified() ? 'fa-check' : 'fa-x' }} small"></i>
                                                                        </span>{{ d_trans('Business owner identity verified') }}
                                                                    </li>
                                                                @endif
                                                                <li class="d-flex align-items-center gap-1">
                                                                    <span
                                                                        class="tool-tip-cross-icon {{ $business->isVerified() ? 'tool-tip-check-icon' : 'tool-tip-times-icon' }} me-2">
                                                                        <i
                                                                            class="fa {{ $business->isVerified() ? 'fa-check' : 'fa-x' }} small"></i>
                                                                    </span>{{ d_trans('Business domain ownership verified') }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="tooltip-badge"
                                                    data-arrow="{{ getDirection() == 'rtl' ? 'right' : 'left' }}">
                                                    <div class="tooltip-hover">
                                                        <i
                                                            class="bi bi-x-circle me-2"></i><span>{{ d_trans('Unclaimed Profile') }}</span>
                                                    </div>
                                                    <div class="tooltip-content">
                                                        <h6 class="mb-2">
                                                            {{ d_trans('Business profile not claimed') }}</h6>
                                                        <span
                                                            class="d-block">{{ d_trans("This business hasn’t yet claimed their profile on our platform and may be unaware it's listed. As a result, their rating might not fully reflect their customer service or responsiveness.") }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex flex-column align-items-center align-items-xl-end">
                            <div class="row row-cols-auto align-items-center justify-content-center g-3">
                                <div class="col">
                                    <a href="{{ $business->website }}" target="_blank"
                                        class="btn btn-outline-primary btn-md">
                                        <i
                                            class="bi bi-box-arrow-up-right icon-rtl me-2"></i>{{ d_trans('Visit Website') }}
                                    </a>
                                </div>
                                @hasSection('write_button')
                                    <div class="col">
                                        <a href="{{ $business->getWriteReviewLink() }}"
                                            class="btn btn-secondary btn-md">
                                            <i class="bi bi-pencil me-2"></i>{{ d_trans('Write a review') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="section section-sm">
        <div class="container @yield('container')">
            <div class="section-inner">
                <div class="section-body">
                    <x-ad alias="business_page_top" @class('container mb-4') />
                    @yield('content')
                    <x-ad alias="business_page_bottom" @class('container mt-4') />
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.scripts')
</body>

</html>
