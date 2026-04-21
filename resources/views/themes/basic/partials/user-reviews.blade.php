@php
    $reviews = $reviews ?? $userReviews ?? collect();
    $reviewAction = $reviewAction ?? null;
    $reviewProduct = $reviewProduct ?? ($product ?? null);
@endphp

{{-- Button to open modal --}}
@auth
    @if ($reviewAction)
        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#reviewModal">
            <i class="fas fa-star me-2"></i>{{ d_trans('Write a Review') }}
        </button>
    @endif
@else
    <p class="text-muted">
        <a href="{{ route('login') }}">{{ d_trans('Login') }}</a> 
        {{ d_trans('or create an account to leave a review.') }}
    </p>
@endauth

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">{{ d_trans('Write a Review') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ $reviewAction }}" method="POST">
                @csrf
                @if ($reviewProduct)
                    <input type="hidden" name="product_id" value="{{ $reviewProduct->id }}">
                @endif
                
                <div class="modal-body">
                    <div class="row g-4">
                        
                        <!-- Star Rating -->
                        <div class="col-12">
                            <label class="form-label fw-medium">{{ d_trans('Rating') }}</label>
                            <div class="star-rating" style="font-size: 2rem; cursor: pointer;">
                                <i class="far fa-star text-warning" data-rating="1"></i>
                                <i class="far fa-star text-warning" data-rating="2"></i>
                                <i class="far fa-star text-warning" data-rating="3"></i>
                                <i class="far fa-star text-warning" data-rating="4"></i>
                                <i class="far fa-star text-warning" data-rating="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="5" required>
                        </div>

                        <!-- Title -->
                        <div class="col-12">
                            <label class="form-label">{{ d_trans('Title') }}</label>
                            <input type="text" name="title" class="form-control" 
                                   value="{{ old('title') }}" maxlength="255" required>
                        </div>

                        <!-- Comment -->
                        <div class="col-12">
                            <label class="form-label">{{ d_trans('Comment') }}</label>
                            <textarea name="body" class="form-control" rows="5" 
                                placeholder="{{ d_trans('Share your thoughts...') }}" required>{{ old('body') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ d_trans('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ d_trans('Submit Review') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .modal-backdrop {
        z-index: 100030 !important;
    }

    .modal {
        z-index: 100040 !important;
    }

    .reviews-shell .card-header {
        background: linear-gradient(120deg, rgba(0, 0, 0, 0.02), rgba(0, 0, 0, 0));
    }

    .review-entry {
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 14px;
        padding: 16px 18px;
        background: #fff;
        box-shadow: 0 10px 26px rgba(0, 0, 0, 0.04);
    }

    .review-meta {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #6c757d;
    }

    .review-stars {
        display: inline-flex;
        gap: 4px;
        color: #f59e0b;
        font-size: 16px;
    }

    .review-actions .btn {
        border-radius: 999px;
        font-weight: 600;
    }

    .review-badge {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 12px;
    }
</style>
@endpush

<!-- Existing Reviews Section -->
<div class="card reviews-shell">
    <div class="card-header fw-medium">{{ d_trans('User Reviews') }}</div>
    <div class="card-body p-4">
        @if ($reviews->count() > 0)
            <div class="d-flex flex-column gap-4">
                @foreach ($reviews as $review)
                    <div class="review-entry">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                            <div class="fw-medium">
                                {{ $review->user?->getName() ?? d_trans('Anonymous') }}
                                @if ($review->product)
                                    <span class="text-muted">·</span>
                                    <a href="{{ $review->product->getLink() }}" class="text-decoration-underline">
                                        {{ $review->product->name }}
                                    </a>
                                @endif
                            </div>
                            <time class="review-meta">{{ dateFormat($review->created_at) }}</time>
                        </div>
                        
                        @if (!$review->is_approved)
                            <div class="badge bg-warning text-dark mt-2 review-badge">
                                {{ d_trans('Pending Approval') }}
                            </div>
                        @endif
                        
                        @if ($review->title)
                            <h6 class="mt-2 mb-1">{{ $review->title }}</h6>
                        @endif
                        
                        <p class="text-muted mb-2">{!! purifier($review->body) !!}</p>
                        
                        <!-- Display Stars -->
                        <div class="mb-3 review-stars">
                            {!! $review->renderStars() !!}
                        </div>

                        <div class="d-flex align-items-center gap-2 review-actions">
                            @auth
                                <form action="{{ route('products.reviews.helpful', $review->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-hand-thumbs-up me-1"></i>{{ d_trans('This was useful') }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-hand-thumbs-up me-1"></i>{{ d_trans('This was useful') }}
                                </a>
                            @endauth
                            <span class="text-muted small">
                                {{ $review->helpful_count ?? 0 }}
                                {{ d_trans('people found this useful') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">{{ d_trans('No reviews yet.') }}</p>
        @endif
    </div>
</div>

{{-- JavaScript for Star Rating --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating i');
    const ratingInput = document.getElementById('ratingInput');
    let currentRating = 5;

    function highlightStars(rating) {
        stars.forEach(star => {
            const starRating = parseInt(star.getAttribute('data-rating'));
            if (starRating <= rating) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }

    stars.forEach(star => {
        star.addEventListener('click', function() {
            currentRating = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = currentRating;
            highlightStars(currentRating);
        });

        // Hover effect
        star.addEventListener('mouseover', function() {
            highlightStars(parseInt(this.getAttribute('data-rating')));
        });
    });

    // Reset on mouse leave
    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
        highlightStars(currentRating);
    });
});
</script>