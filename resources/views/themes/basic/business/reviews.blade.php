@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Reviews'))
@section('header_title', d_trans('Reviews'))
@section('breadcrumbs', Breadcrumbs::render('business.reviews'))
@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="row row-cols-1 g-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body p-4">
                                    <p class="fw-medium">{{ d_trans('Search') }}</p>
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
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body p-4">
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
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body p-4">
                                    <p class="fw-medium">{{ d_trans('Rating') }}</p>
                                    <div class="row row-cols-1 g-3">
                                        <div class="col">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input id="rating5" type="checkbox" name="stars"
                                                    class="form-check-input search-param my-0" value="5" />
                                                <label
                                                    class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                    for="rating5">
                                                    <span class="text-muted">{{ d_trans('Excellent') }}</span>
                                                    <div class="ratings">
                                                        <img src="{{ asset(config('theme.settings.stars.stars_5')) }}"
                                                            alt="{{ d_trans('Excellent') }}">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input id="rating4" type="checkbox" name="stars"
                                                    class="form-check-input search-param my-0" value="4" />
                                                <label
                                                    class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                    for="rating4">
                                                    <span class="text-muted">{{ d_trans('Great') }}</span>
                                                    <div class="ratings">
                                                        <img src="{{ asset(config('theme.settings.stars.stars_4')) }}"
                                                            alt="{{ d_trans('Great') }}">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input id="rating3" type="checkbox" name="stars"
                                                    class="form-check-input search-param my-0" value="3" />
                                                <label
                                                    class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                    for="rating3">
                                                    <span class="text-muted">{{ d_trans('Average') }}</span>
                                                    <div class="ratings">
                                                        <img src="{{ asset(config('theme.settings.stars.stars_3')) }}"
                                                            alt="{{ d_trans('Average') }}">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input id="rating2" type="checkbox" name="stars"
                                                    class="form-check-input search-param my-0" value="2" />
                                                <label
                                                    class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                    for="rating2">
                                                    <span class="text-muted">{{ d_trans('Fair') }}</span>
                                                    <div class="ratings">
                                                        <img src="{{ asset(config('theme.settings.stars.stars_2')) }}"
                                                            alt="{{ d_trans('Fair') }}">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input id="rating1" type="checkbox" name="stars"
                                                    class="form-check-input search-param my-0" value="1" />
                                                <label
                                                    class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                                    for="rating1">
                                                    <span class="text-muted">{{ d_trans('Poor') }}</span>
                                                    <div class="ratings">
                                                        <img src="{{ asset(config('theme.settings.stars.stars_1')) }}"
                                                            alt="{{ d_trans('Poor') }}">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            @if ($reviews->count() > 0)
                <div class="row row-cols-1 g-3">
                    @foreach ($reviews as $review)
                        @php
                            $reviewer = $review->reviewer;
                            $registeredUser = $review->user;
                            $reviewBusiness = $review->business;
                        @endphp
                        <div class="col">
                            <div class="item-review">
                                <div class="box">
                                    <div class="item-review-header">
                                        <div class="user gap-3">
                                            @if ($reviewer->profile_link)
                                                <a href="{{ $reviewer->profile_link }}" target="_blank"
                                                    class="user-avatar user-avatar-md">
                                                    <img src="{{ $reviewer->avatar }}" alt="{{ $reviewer->name }}" />
                                                </a>
                                            @else
                                                <span class="user-avatar user-avatar-md">
                                                    <img src="{{ $reviewer->avatar }}" alt="{{ $reviewer->name }}" />
                                                </span>
                                            @endif
                                            <div class="user-info">
                                                <div class="fw-medium">
                                                    @if ($reviewer->profile_link)
                                                        <a href="{{ $reviewer->profile_link }}"
                                                            target="_blank">{{ $reviewer->name }}</a>
                                                    @else
                                                        <span>{{ $reviewer->name }}</span>
                                                    @endif
                                                    @if ($registeredUser)
                                                        @if ($registeredUser->isBanned())
                                                            <span class="badge bg-danger p-1 ms-1"><i
                                                                    class="fas fa-user-slash me-1"></i>{{ d_trans('Banned') }}</span>
                                                        @elseif ($registeredUser->hasKycVerified())
                                                            <i class="bi bi-patch-check-fill verified-icon"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-title="{{ d_trans('Identity Verified') }}"></i>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-warning p-1 ms-1"><i
                                                                class="fas fa-user-times me-1"></i>{{ d_trans('Guest') }}</span>
                                                    @endif
                                                </div>
                                                <a href="{{ $review->getLink() }}" target="_blank" class="text-muted">
                                                    <time class="small">
                                                        {{ $review->created_at->diffforhumans() }}
                                                    </time>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-review-body">
                                        <h5 class="item-review-title">{{ $review->trans->title }}</h5>
                                        <p class="item-review-text">{!! purifier($review->trans->body) !!}</p>
                                        <div class="row align-items-center g-3">
                                            <div class="col-12 col-lg">
                                                <div class="ratings ratings-lg">
                                                    <img src="{{ $review->getRatingImageLink() }}"
                                                        alt="{{ $review->stars }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-auto">
                                                <h6>{{ d_trans('Date of experience') }}:
                                                    <span
                                                        class="fw-light">{{ dateFormat($review->experience_date, 'M d, Y') }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!$review->hasReply())
                                        <div class="item-review-footer">
                                            <div class="item-review-actions">
                                                <button class="item-review-action btn btn-reset" data-bs-toggle="collapse"
                                                    data-bs-target="#reply{{ $review->id }}">
                                                    <i class="bi bi-reply icon-rtl me-2"></i>{{ d_trans('Reply') }}
                                                </button>
                                            </div>
                                            <div class="item-review-actions-content">
                                                <div class="mt-3 collapse" id="reply{{ $review->id }}"
                                                    data-bs-parent="#accordion">
                                                    <form action="{{ route('business.reviews.reply', $review->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <textarea name="reply" class="form-control py-3 fs-6" rows="6" placeholder="{{ d_trans('Your reply') }}"
                                                                required></textarea>
                                                        </div>
                                                        <button
                                                            class="btn btn-primary action-confirm p-2 px-4">{{ d_trans('Publish') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($review->hasReply())
                                        @php
                                            $reply = $review->reply;
                                            $repliedOwner = $reply->owner;
                                        @endphp
                                        <div class="item-review-reply">
                                            <div class="row g-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-reply text-primary fa-lg icon-rtl"></i>
                                                </div>
                                                <div class="col">
                                                    <div class="item-review">
                                                        <div class="item-review-header">
                                                            <div class="row align-items-center g-3">
                                                                <div class="col">
                                                                    @if (authBusinessOwner()->isAdminOfCurrentBusiness() || $repliedOwner->id == authBusinessOwner()->id)
                                                                        <div class="user gap-2">
                                                                            @if ($repliedOwner->id == authBusinessOwner()->id)
                                                                                <span class="user-avatar user-avatar-sm">
                                                                                    <img src="{{ $repliedOwner->getAvatar() }}"
                                                                                        alt="{{ $repliedOwner->getName() }}" />
                                                                                </span>
                                                                            @else
                                                                                <a href="{{ route('business.employees.index') }}"
                                                                                    class="user-avatar user-avatar-sm">
                                                                                    <img src="{{ $repliedOwner->getAvatar() }}"
                                                                                        alt="{{ $repliedOwner->getName() }}" />
                                                                                </a>
                                                                            @endif
                                                                            <div class="user-info">
                                                                                <div class="user-title fw-medium">
                                                                                    @if ($repliedOwner->id == authBusinessOwner()->id)
                                                                                        <span>{{ $repliedOwner->getName() }}</span>
                                                                                    @else
                                                                                        <a
                                                                                            href="{{ route('business.employees.index') }}">{{ $repliedOwner->getName() }}</a>
                                                                                    @endif
                                                                                    @if ($repliedOwner->hasKycVerified())
                                                                                        <i class="bi bi-patch-check-fill verified-icon"
                                                                                            data-bs-toggle="tooltip"
                                                                                            data-bs-title="{{ d_trans('Identity Verified') }}"></i>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="user gap-2">
                                                                            <a href="{{ $reviewBusiness->getLink() }}"
                                                                                class="user-avatar user-avatar-sm">
                                                                                <img src="{{ $reviewBusiness->getLogoLink() }}"
                                                                                    alt="{{ $reviewBusiness->trans->name }}" />
                                                                            </a>
                                                                            <div class="user-info">
                                                                                <div class="user-title fw-medium">
                                                                                    <a
                                                                                        href="{{ $reviewBusiness->getLink() }}">{{ $reviewBusiness->trans->name }}</a>
                                                                                    @if ($reviewBusiness->isVerified())
                                                                                        <i class="bi bi-patch-check-fill verified-icon"
                                                                                            data-bs-toggle="tooltip"
                                                                                            data-bs-title="{{ d_trans('Verified') }}"></i>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-auto">
                                                                    <time
                                                                        class="text-muted small">{{ $reply->created_at->diffforhumans() }}</time>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="item-review-body">
                                                            <p class="item-review-text">{!! purifier($reply->trans->body) !!}</p>
                                                        </div>
                                                        @if (authBusinessOwner()->isAdminOfCurrentBusiness() || $reply->owner->id == authBusinessOwner()->id)
                                                            <div class="item-review-footer">
                                                                <div class="item-review-actions">
                                                                    <button class="btn btn-outline-dark btn-sm"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#editReply{{ $review->id }}">
                                                                        <i
                                                                            class="bi bi-pencil-square me-2"></i>{{ d_trans('Edit') }}
                                                                    </button>
                                                                </div>
                                                                <div class="item-review-actions-content">
                                                                    <div class="mt-3 collapse"
                                                                        id="editReply{{ $review->id }}"
                                                                        data-bs-parent="#accordion">
                                                                        <form
                                                                            action="{{ route('business.reviews.reply.update', $review->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="mb-3">
                                                                                <textarea name="reply" class="form-control py-3 fs-6" rows="6" placeholder="{{ d_trans('Your reply') }}"
                                                                                    required>{{ $reply->body }}</textarea>
                                                                            </div>
                                                                            <button
                                                                                class="btn btn-primary action-confirm p-2 px-4">{{ d_trans('Save') }}</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $reviews->links() }}
            @else
                <div class="card">
                    <div class="card-body p-5">
                        @include('themes.basic.business.partials.empty', ['empty_classes' => 'empty-lg'])
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
