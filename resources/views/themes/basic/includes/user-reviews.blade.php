@php
	$reviews = $reviews ?? $userReviews ?? collect();
	$reviewAction = $reviewAction ?? null;
	$reviewProduct = $reviewProduct ?? ($product ?? null);
@endphp

<div class="card mb-4">
	<div class="card-header fw-medium">{{ d_trans('Add a Review') }}</div>
	<div class="card-body p-4">
		@auth
			@if ($reviewAction)
				<form action="{{ $reviewAction }}" method="POST">
					@csrf
					@if ($reviewProduct)
						<input type="hidden" name="product_id" value="{{ $reviewProduct->id }}">
					@endif
					<div class="row g-3">
						<div class="col-12">
							<label class="form-label">{{ d_trans('Title') }}</label>
							<input type="text" name="title" class="form-control form-control-md"
								value="{{ old('title') }}" maxlength="255" required>
						</div>
						<div class="col-12">
							<label class="form-label">{{ d_trans('Comment') }}</label>
							<textarea name="body" class="form-control form-control-md" rows="4"
								placeholder="{{ d_trans('Share your thoughts...') }}" required>{{ old('body') }}</textarea>
						</div>
						<div class="col-12">
							<button class="btn btn-primary btn-md">{{ d_trans('Submit Review') }}</button>
						</div>
					</div>
				</form>
			@else
				<p class="text-muted mb-0">{{ d_trans('Review form is not configured yet.') }}</p>
			@endif
		@else
			<p class="text-muted mb-0">
				<a href="{{ route('login') }}">{{ d_trans('Login') }}</a>
				{{ d_trans('or create an account to leave a review.') }}
			</p>
		@endauth
	</div>
</div>

<div class="card">
	<div class="card-header fw-medium">{{ d_trans('User Reviews') }}</div>
	<div class="card-body p-4">
		@if ($reviews->count() > 0)
			<div class="d-flex flex-column gap-4">
				@foreach ($reviews as $review)
					<div class="border-bottom pb-4">
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
							<time class="text-muted small">{{ dateFormat($review->created_at) }}</time>
						</div>
						@if (!$review->is_approved)
							<div class="badge bg-warning text-dark mt-2">{{ d_trans('Pending Approval') }}</div>
						@endif
						@if ($review->title)
							<h6 class="mt-2 mb-1">{{ $review->title }}</h6>
						@endif
						<p class="text-muted mb-0">{!! purifier($review->body) !!}</p>
						<div class="d-flex align-items-center gap-2 mt-3">
							@auth
								<form action="{{ route('products.reviews.helpful', $review->id) }}" method="POST">
									@csrf
									<button type="submit" class="btn btn-outline-primary btn-sm">
										<i class="bi bi-hand-thumbs-up me-1"></i>{{ d_trans('Helpful') }}
									</button>
								</form>
							@else
								<a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
									<i class="bi bi-hand-thumbs-up me-1"></i>{{ d_trans('Helpful') }}
								</a>
							@endauth
							<span class="text-muted small">
								{{ $review->helpful_count ?? 0 }}
								{{ Str::plural('helpful', $review->helpful_count ?? 0) }}
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
