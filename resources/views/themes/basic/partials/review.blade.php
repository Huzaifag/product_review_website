@php
    $reviewer = $review->reviewer;
    $reviewBusiness = $review->business;
@endphp
<div class="item-review">
    @if (isset($review_header))
        <p class="text-muted mb-2">
            {!! d_trans('Review of :business_name', [
                'business_name' =>
                    '<a href="' .
                    $reviewBusiness->getLink() .
                    '" class="text-decoration-underline">' .
                    $reviewBusiness->trans->name .
                    '</a>',
            ]) !!}
        </p>
    @endif
    <div class="box">
        <div class="item-review-header">
            <div class="row align-items-center g-3">
                <div class="col">
                    <div class="user gap-3">
                        @if ($reviewer->profile_link)
                            <a href="{{ $reviewer->profile_link }}" class="user-avatar user-avatar-md">
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
                                    <a href="{{ $reviewer->profile_link }}">{{ $reviewer->name }}</a>
                                @else
                                    <span>{{ $reviewer->name }}</span>
                                @endif
                                @php
                                    $registeredUser = $review->user;
                                @endphp
                                @if ($registeredUser)
                                    @if ($registeredUser->isBanned())
                                        <span class="badge bg-danger p-1 ms-1"><i
                                                class="fas fa-user-slash me-1"></i>{{ d_trans('Banned') }}</span>
                                    @elseif ($registeredUser->hasKycVerified())
                                        <i class="bi bi-patch-check-fill verified-icon" data-bs-toggle="tooltip"
                                            data-bs-title="{{ d_trans('Identity Verified') }}"></i>
                                    @endif
                                @else
                                    <span class="badge bg-warning p-1 ms-1"><i
                                            class="fas fa-user-times me-1"></i>{{ d_trans('Guest') }}</span>
                                @endif
                            </div>
                            <a href="{{ $review->getLink() }}" class="text-muted">
                                <time class="small">
                                    {{ $review->created_at->diffforhumans() }}
                                </time>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    @if (authUser())
                        <button class="item-review-action btn btn-reset" data-bs-toggle="collapse"
                            data-bs-target="#report{{ $review->id }}">
                            <i class="bi bi-flag"></i>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="item-review-action btn btn-reset">
                            <i class="bi bi-flag"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="item-review-body">
            <h5 class="item-review-title">{{ $review->trans->title }}</h5>
            <p class="item-review-text">{!! purifier($review->trans->body) !!}</p>
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg">
                    <div class="ratings ratings-lg">
                        <img src="{{ $review->getRatingImageLink() }}" alt="{{ $review->stars }}" />
                    </div>
                </div>
                <div class="col-12 col-lg-auto">
                    <h6>{{ d_trans('Date of experience') }}:
                        <span class="fw-light">{{ dateFormat($review->experience_date, 'M d, Y') }}</span>
                    </h6>
                </div>
            </div>
        </div>
        <div class="item-review-footer">
            <div class="item-review-actions">
                <livewire:review-likes :reviewId="$review->id" />
                <div class="dropdown">
                    <button class="btn btn-reset item-review-action d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-share"></i>
                        <span>{{ d_trans('Share') }}</span>
                    </button>
                    <div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuButton">
                        @include('themes.basic.partials.share-buttons', [
                            'link' => $review->getLink(),
                            'socials_classes' => 'socials-sm flex-nowrap',
                            'no_colors' => true,
                        ])
                    </div>
                </div>
                @if ($review->isForCurrentUser())
                    <div class="row row-cols-auto ms-auto g-2">
                        <div class="col">
                            <button class="item-review-action btn btn-reset" data-bs-toggle="collapse"
                                data-bs-target="#edit{{ $review->id }}">
                                <i class="bi bi-pencil-square me-2"></i>{{ d_trans('Edit') }}
                            </button>
                        </div>
                        <div class="col">
                            <form
                                action="{{ route('businesses.review.delete', [$reviewBusiness->domain, $review->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="_referrer" value="{{ $review_referrer }}">
                                <button class="item-review-action action-confirm btn btn-reset">
                                    <i class="bi bi-trash me-2"></i>{{ d_trans('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            <div class="item-review-actions-content">
                @if ($review->isForCurrentUser())
                    <div class="mt-3 collapse" id="edit{{ $review->id }}" data-bs-parent="#accordion">
                        <form action="{{ route('businesses.review.update', [$reviewBusiness->domain, $review->id]) }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="description" class="form-control py-3 fs-6" rows="6"
                                    placeholder="{{ d_trans('Share your thoughts, what you liked or disliked...') }}" minlength="60" maxlength="4000"
                                    required>{{ $review->body }}</textarea>
                            </div>
                            <button class="btn btn-primary action-confirm p-2 px-4">{{ d_trans('Save') }}</button>
                        </form>
                    </div>
                @endif
                @if (authUser())
                    <div class="mt-3 collapse" id="report{{ $review->id }}" data-bs-parent="#accordion">
                        <form action="{{ route('businesses.review.report', [$reviewBusiness->domain, $review->id]) }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="report_reason" class="form-control py-3 fs-6" rows="2"
                                    placeholder="{{ d_trans('Report reason?') }}" required></textarea>
                            </div>
                            <button class="btn btn-primary p-2 px-4">{{ d_trans('Send') }}</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        @if ($review->hasReply())
            @php
                $reply = $review->reply;
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
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
