@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Businesses'))
@section('title', d_trans('Business Reviews'))
@section('header_title', d_trans(':business_name Reviews', ['business_name' => $business->trans->name]))
@section('back', route('admin.businesses.index'))
@section('business_view', true)
@section('content')
    @include('admin.businesses.includes.tabs')
    <div class="row g-3">
        <div class="col-lg-3">
            <div class="card h-100">
                <div class="card-body p-4">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row row-cols-1 g-4">
                            <div class="col">
                                <p class="fw-medium">{{ d_trans('Search') }}</p>
                                <form class="search-form" method="GET">
                                    <div class="form-search form-search-reverse">
                                        <div class="icon">
                                            <i class="bi bi-search"></i>
                                        </div>
                                        <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                            class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <p class="fw-medium">{{ d_trans('Date') }}</p>
                                <div class="mb-3">
                                    <input type="text" name="date_from"
                                        class="form-control form-control-md auto-search-input"
                                        placeholder="{{ d_trans('From Date') }}" onfocus="(this.type='date')"
                                        onblur="(this.type='text')" value="{{ request('date_from') }}">
                                </div>
                                <div>
                                    <input type="text" name="date_to"
                                        class="form-control form-control-md auto-search-input"
                                        placeholder="{{ d_trans('To Date') }}" onfocus="(this.type='date')"
                                        onblur="(this.type='text')" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col">
                                <p class="fw-medium">{{ d_trans('Rating') }}</p>
                                <div class="row row-cols-1 g-3">
                                    <div class="col">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input id="rating5" type="checkbox" name="stars[]"
                                                class="form-check-input search-param my-0" value="5"
                                                @checked(in_array(5, request('stars') ?? [])) />
                                            <label
                                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                for="rating5">
                                                <span class="text-muted">{{ d_trans('Excellent') }}</span>
                                                <div class="ratings">
                                                    <img src="{{ asset(config('theme.settings.stars.stars_5')) }}"
                                                        alt="{{ d_trans('Excellent') }}" width="80px">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input id="rating4" type="checkbox" name="stars[]"
                                                class="form-check-input search-param my-0" value="4"
                                                @checked(in_array(4, request('stars') ?? [])) />
                                            <label
                                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                for="rating4">
                                                <span class="text-muted">{{ d_trans('Great') }}</span>
                                                <div class="ratings">
                                                    <img src="{{ asset(config('theme.settings.stars.stars_4')) }}"
                                                        alt="{{ d_trans('Great') }}" width="80px">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input id="rating3" type="checkbox" name="stars[]"
                                                class="form-check-input search-param my-0" value="3"
                                                @checked(in_array(3, request('stars') ?? [])) />
                                            <label
                                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                for="rating3">
                                                <span class="text-muted">{{ d_trans('Average') }}</span>
                                                <div class="ratings">
                                                    <img src="{{ asset(config('theme.settings.stars.stars_3')) }}"
                                                        alt="{{ d_trans('Average') }}" width="80px">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input id="rating2" type="checkbox" name="stars[]"
                                                class="form-check-input search-param my-0" value="2"
                                                @checked(in_array(2, request('stars') ?? [])) />
                                            <label
                                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                for="rating2">
                                                <span class="text-muted">{{ d_trans('Fair') }}</span>
                                                <div class="ratings">
                                                    <img src="{{ asset(config('theme.settings.stars.stars_2')) }}"
                                                        alt="{{ d_trans('Fair') }}" width="80px">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input id="rating1" type="checkbox" name="stars[]"
                                                class="form-check-input search-param my-0" value="1"
                                                @checked(in_array(1, request('stars') ?? [])) />
                                            <label
                                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                for="rating1">
                                                <span class="text-muted">{{ d_trans('Poor') }}</span>
                                                <div class="ratings">
                                                    <img src="{{ asset(config('theme.settings.stars.stars_1')) }}"
                                                        alt="{{ d_trans('Poor') }}" width="80px">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary btn-md w-100 mb-3">{{ d_trans('Search') }}</button>
                                <a href="{{ url()->current() }}"
                                    class="btn btn-soft btn-md w-100">{{ d_trans('Reset') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            @if ($reviews->count() > 0)
                <div class="row g-3 row-cols-1">
                    @foreach ($reviews as $review)
                        <div class="col">
                            @include('admin.partials.review', ['review' => $review])
                        </div>
                    @endforeach
                </div>
                {{ $reviews->links() }}
            @else
                <div class="card h-100">
                    <div class="card-body col-lg-8 m-auto p-4">
                        @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
