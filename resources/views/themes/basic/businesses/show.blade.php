@extends('themes.basic.businesses.layout')
@section('title', d_trans(':business_name Reviews - Read Reviews About :business_domain', ['business_name' =>
    ucFirst($business->trans->name), 'business_domain' => $business->domain]))
@section('description', $business->trans->short_description)
@section('keywords', $business->trans->tags)
@section('og_image', $business->getLogoLink())
@if ($business->hasCategory())
    @section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'businesses.show', $business))
    @section('breadcrumbs', Breadcrumbs::render('businesses.show', $business))
@endif
@section('container', 'container-custom')
@section('write_button', true)
@section('content')
    <div id="searchPage" class="row g-3">
        <div class="col-12 col-xl-8">
            <div class="row row-cols-1 g-3">
                <div class="col">
                    <div class="item-box box">
                        <div class="item-box-header">
                            <h4 class="item-box-title mb-0">{{ d_trans('Average Rating') }}</h4>
                        </div>
                        <div class="item-box-body">
                            <div class="rating-box">
                                <div class="rating-number">
                                    <div class="d-flex align-items-end">
                                        <p class="rating-value mb-0">{{ $business->avg_ratings }}</p>
                                        <div class="rating-divider">/</div>
                                        <span class="rating-max">5</span>
                                    </div>
                                    <p class="rating-desc mb-0">
                                        {{ translate_choice(':count Review|:count Reviews', $business->total_reviews, [
                                            'count' => numberFormat($business->total_reviews),
                                        ]) }}
                                    </p>
                                </div>
                                <div class="ratings-rows">
                                    @foreach ([5, 4, 3, 2, 1] as $star)
                                        <div class="ratings-row">
                                            <div class="ratings-row-text">
                                                <input type="checkbox" class="form-check-input search-param m-0"
                                                    name="stars[]" value="{{ $star }}" data-multiple="true"
                                                    id="stars{{ $star }}">
                                                <span>{{ d_trans(':number Star', ['number' => $star]) }}</span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    aria-valuenow="{{ $starPercentages[$star] }}" aria-valuemin="0"
                                                    aria-valuemax="100" style="width: {{ $starPercentages[$star] }}%;">
                                                </div>
                                            </div>
                                            <span>{{ $starPercentages[$star] }}%</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="my-3">
                        <div class="row row-cols-auto align-items-center justify-content-between g-3">
                            <div class="col">
                                <h4 class="item-box-title mb-0">
                                    {{ collect(request()->query())->count() > 0 ? d_trans('Filtered Reviews') : d_trans('All Reviews') }}
                                </h4>
                            </div>
                            <div class="col">
                                <button class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#filters">
                                    <i class="bi bi-funnel"></i><span
                                        class="ms-2 d-none d-lg-inline">{{ d_trans('More Filters') }}<i
                                            class="bi bi-chevron-down ms-2"></i></span>
                                </button>
                                @if (collect(request()->query())->only(['search', 'country', 'review_time'])->count() > 0)
                                    <a href="{{ url()->current() }}" class="btn btn-outline-primary ms-1"><i
                                            class="bi bi-arrow-repeat me-2"></i>{{ d_trans('Reset') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="filters"
                        class="collapse {{ collect(request()->query())->only(['search', 'country', 'review_time'])->count() > 0? 'show': '' }}">
                        <div class="item-box box">
                            <h4 class="item-box-title mb-4">{{ d_trans('Filter Reviews') }} </h4>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <form class="search-form" method="GET">
                                        <div class="form-search form-search-reverse">
                                            <button class="icon">
                                                <i class="bi bi-search"></i>
                                            </button>
                                            <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                                class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-6">
                                    <select name="country" class="selectpicker selectpicker-md search-select"
                                        title="{{ d_trans('Country') }}" data-size="5" data-live-search="true">
                                        <option value="">{{ d_trans('All') }}</option>
                                        @foreach (countries() as $countryCode => $countryName)
                                            <option value="{{ $countryCode }}" @selected(request('country') == $countryCode)>
                                                {{ $countryName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="item-box box p-3">
                                        <p class="fw-medium">{{ d_trans('Review Time') }}</p>
                                        <div class="row row-cols-1 row-cols-lg-5 g-3">
                                            <div class="col">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="review_time" value=""
                                                        class="form-check-input search-param my-0" id="reviewTime11" />
                                                    <label class="form-check-label text-muted"
                                                        for="reviewTime11">{{ d_trans('Any time') }}</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="review_time" value="this_month"
                                                        class="form-check-input search-param my-0" id="reviewTime22" />
                                                    <label class="form-check-label text-muted"
                                                        for="reviewTime22">{{ d_trans('This month') }}</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="review_time" value="last_month"
                                                        class="form-check-input search-param my-0" id="reviewTime33" />
                                                    <label class="form-check-label text-muted"
                                                        for="reviewTime33">{{ d_trans('Last month') }}</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="review_time" value="this_year"
                                                        class="form-check-input search-param my-0" id="reviewTime44" />
                                                    <label class="form-check-label text-muted"
                                                        for="reviewTime44">{{ d_trans('This year') }}</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="review_time" value="last_year"
                                                        class="form-check-input search-param my-0" id="reviewTime55" />
                                                    <label class="form-check-label text-muted"
                                                        for="reviewTime55">{{ d_trans('Last year') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($reviews->count() > 0)
                        <div class="item-reviews mt-3">
                            @foreach ($reviews as $key => $review)
                                @include('themes.basic.partials.review', [
                                    'review' => $review,
                                    'review_referrer' => $business->getLink(),
                                ])
                                @if ($key == 2)
                                    <x-ad alias="business_page_center" />
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="mt-3">
                            @include('themes.basic.partials.empty-box', [
                                'empty_image' => 'v2',
                                'title' => d_trans('No Reviews Found'),
                                'description' => d_trans(
                                    'No reviews have been submitted for this business or no matches for your search'),
                            ])
                        </div>
                    @endif
                </div>
                {{ $reviews->links() }}
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="row row-cols-1 g-3">
                @if (!$business->isClaimed())
                    <div class="col">
                        <div class="item-box box">
                            <div class="item-box-header">
                                <h4 class="item-box-title mb-0">{{ d_trans('Is this your business?') }}</h4>
                            </div>
                            <div class="item-box-body">
                                <p class="mb-3">
                                    {{ d_trans('Claim your business profile now and gain access to all features and respond to customer reviews.') }}
                                </p>
                                <form action="{{ route('businesses.claim', hash_encode($business->id)) }}"
                                    method="POST">
                                    @csrf
                                    <button
                                        class="btn btn-outline-primary btn-md w-100">{{ d_trans('Claim Business Profile') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($business->description || $business->hasAddressCompleted() || $business->email || $business->phone)
                    <div class="col">
                        <div class="item-box box">
                            <div class="item-box-header">
                                <h4 class="item-box-title mb-0">{{ d_trans('Business Details') }}</h4>
                            </div>
                            <div class="item-box-body">
                                <ul class="d-flex flex-column gap-3 list-unstyled mb-0">
                                    @if ($business->description)
                                        <li>
                                            <p class="item-box-text text-muted mb-0">{!! purifier($business->trans->description) !!}</p>
                                        </li>
                                    @endif
                                    @if ($business->hasAddressCompleted())
                                        <li>
                                            <h6 class="mb-1"><i
                                                    class="bi bi-geo-alt me-2"></i>{{ d_trans('Location') }}
                                            </h6>
                                            <a href="{{ $business->getGoogleMapAddress() }}" target="_blank"
                                                class="item-box-text text-muted mb-0">
                                                {{ $business->city . ', ' . $business->getCountry() }}
                                            </a>
                                        </li>
                                    @endif
                                    @if ($business->email)
                                        <li>
                                            <h6 class="mb-1"><i
                                                    class="bi bi-envelope-at me-2"></i>{{ d_trans('Email') }}
                                            </h6>
                                            <a href="mailto:{{ $business->email }}"
                                                class="item-box-text text-muted mb-0">{{ $business->email }}</a>
                                        </li>
                                    @endif
                                    @if ($business->phone)
                                        <li>
                                            <h6 class="mb-1"><i class="bi bi-telephone me-2"></i>{{ d_trans('Phone') }}
                                            </h6>
                                            <a href="tel:{{ $business->phone }}"
                                                class="item-box-text text-muted mb-0">{{ $business->phone }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @php
                    $socialLinks = $business->social_links;
                @endphp
                @if (
                    ($socialLinks && @$socialLinks->facebook) ||
                        @$socialLinks->x ||
                        @$socialLinks->linkedin ||
                        @$socialLinks->youtube ||
                        @$socialLinks->instagram ||
                        @$socialLinks->pinterest)
                    <div class="col">
                        <div class="item-box box">
                            <div class="item-box-header">
                                <h4 class="item-box-title mb-0">{{ d_trans('Business Social Links') }}
                                </h4>
                            </div>
                            <div class="item-box-body">
                                <div class="socials socials-sm">
                                    @if (@$socialLinks->facebook)
                                        <a href="https://facebook.com/{{ @$socialLinks->facebook }}" target="_blank"
                                            class="social-btn social-facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif
                                    @if (@$socialLinks->x)
                                        <a href="https://x.com/{{ @$socialLinks->x }}" target="_blank"
                                            class="social-btn social-x">
                                            <i class="fab fa-x-twitter"></i>
                                        </a>
                                    @endif
                                    @if (@$socialLinks->linkedin)
                                        <a href="https://linkedin.com/in/{{ @$socialLinks->linkedin }}" target="_blank"
                                            class="social-btn social-linkedin">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    @endif
                                    @if (@$socialLinks->youtube)
                                        <a href="https://youtube.com/{{ '@' . @$socialLinks->youtube }}" target="_blank"
                                            class="social-btn social-youtube">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    @endif
                                    @if (@$socialLinks->instagram)
                                        <a href="https://instagram.com/{{ @$socialLinks->instagram }}" target="_blank"
                                            class="social-btn social-instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif
                                    @if (@$socialLinks->pinterest)
                                        <a href="https://pinterest.com/{{ @$socialLinks->pinterest }}" target="_blank"
                                            class="social-btn social-pinterest">
                                            <i class="fab fa-pinterest"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <x-ad alias="business_page_sidebar" @class('col') />
                @if ($similarBusinesses->count() > 0)
                    <div class="col">
                        <div class="item-box box">
                            <div class="item-box-header">
                                <h4 class="item-box-title mb-0">
                                    {{ $business->hasCategory() ? d_trans('Similar Businesses') : d_trans('More Businesses') }}
                                </h4>
                            </div>
                            <div class="item-box-body">
                                <ul class="list-unstyled d-flex flex-column gap-1 mb-0">
                                    @foreach ($similarBusinesses as $similarBusiness)
                                        <li>
                                            <a href="{{ $similarBusiness->getLink() }}"
                                                class="d-flex align-items-center justify-content-between gap-3">
                                                <div class="item-sm d-flex align-items-center gap-3 overflow-hidden py-2">
                                                    <div class="item-img flex-shrink-0">
                                                        <img loading="lazy" src="{{ $similarBusiness->getLogoLink() }}"
                                                            alt="{{ $similarBusiness->trans->name }}">
                                                        @if ($similarBusiness->isVerified())
                                                            <div class="item-verified">
                                                                <i class="bi bi-patch-check-fill" data-bs-toggle="tooltip"
                                                                    data-bs-title="{{ d_trans('Verified') }}"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="item-info">
                                                        <h6 class="item-title text-truncate">
                                                            {{ $similarBusiness->trans->name }}</h6>
                                                        <p class="item-link small text-muted mb-0">
                                                            {{ $similarBusiness->domain }}</p>
                                                    </div>
                                                </div>
                                                <div class="ratings">
                                                    <img loading="lazy"
                                                        src="{{ $similarBusiness->getAvgRatingImageLink() }}"
                                                        alt="{{ $similarBusiness->avg_ratings }}" />
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('schema')
        {!! schema($__env, 'business', ['business' => $business]) !!}
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/autosize/autosize.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
