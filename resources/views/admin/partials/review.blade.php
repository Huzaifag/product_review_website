@php
    $user = $review->user;
    $reviewer = $review->reviewer;
    $reviewBusiness = $review->business;
@endphp
<div class="item-review">
    <div class="box">
        <div class="item-review-header">
            <div class="row align-items-center g-3">
                <div class="user gap-3">
                    @if ($user)
                        <a href="{{ route('admin.members.users.edit', $user->id) }}" class="user-avatar user-avatar-md">
                            <img src="{{ $reviewer->avatar }}" alt="{{ $reviewer->name }}" />
                        </a>
                    @else
                        <span class="user-avatar user-avatar-md">
                            <img src="{{ $reviewer->avatar }}" alt="{{ $reviewer->name }}" />
                        </span>
                    @endif
                    <div class="user-info">
                        <div class="fw-medium">
                            @if ($user)
                                <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                    class="text-dark">{{ $reviewer->name }}</a>
                            @else
                                <span>{{ $reviewer->name }}</span>
                            @endif
                            @if ($user)
                                @if ($user->isBanned())
                                    <span class="badge bg-danger p-1 ms-1"><i
                                            class="fas fa-user-slash me-1"></i>{{ d_trans('Banned') }}</span>
                                @elseif ($user->hasKycVerified())
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
        </div>
        <div class="item-review-body">
            <h5 class="item-review-title">{{ $review->trans->title }}</h5>
            <p class="item-review-text">{!! purifier($review->trans->body) !!}</p>
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg">
                    <div class="ratings ratings-lg">
                        <img src="{{ $review->getRatingImageLink() }}" alt="{{ $review->stars }}" width="140px" />
                    </div>
                </div>
                <div class="col-12 col-lg-auto">
                    <h6>{{ d_trans('Date of experience') }}:
                        <span class="fw-light">{{ dateFormat($review->experience_date, 'M d, Y') }}</span>
                    </h6>
                </div>
            </div>
        </div>
        @if (!isset($review_only))
            <div class="item-review-footer">
                <div class="item-review-actions">
                    <form action="{{ route('admin.businesses.reviews.delete', [$reviewBusiness->id, $review->id]) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger action-confirm"><i
                                class="bi bi-trash me-2"></i>{{ d_trans('Delete Review') }}</button>
                    </form>
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
                                        <div class="user gap-2">
                                            <a href="{{ route('admin.members.business-owners.edit', $repliedOwner->id) }}"
                                                class="user-avatar user-avatar-sm">
                                                <img src="{{ $repliedOwner->getAvatar() }}"
                                                    alt="{{ $repliedOwner->getName() }}" />
                                            </a>
                                            <div class="user-info">
                                                <div class="user-title fw-medium">
                                                    <a href="{{ route('admin.members.business-owners.edit', $repliedOwner->id) }}"
                                                        class="text-dark">{{ $repliedOwner->getName() }}</a>
                                                    @if ($repliedOwner->hasKycVerified())
                                                        <i class="bi bi-patch-check-fill verified-icon"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-title="{{ d_trans('Identity Verified') }}"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <time class="text-muted small">{{ $reply->created_at->diffforhumans() }}</time>
                                    </div>
                                </div>
                            </div>
                            <div class="item-review-body">
                                <p class="item-review-text">{!! purifier($reply->trans->body) !!}</p>
                                @if (!isset($review_only))
                                    <div class="mt-3">
                                        <form
                                            action="{{ route('admin.businesses.reviews.reply.delete', [$reviewBusiness->id, $review->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-soft action-confirm"><i
                                                    class="bi bi-trash me-2"></i>{{ d_trans('Delete Reply') }}</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
