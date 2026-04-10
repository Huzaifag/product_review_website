@extends('themes.basic.businesses.layout')
@section('title', d_trans('Rate :business_name', ['business_name' => ucFirst($business->trans->name)]))
@section('description', $business->trans->short_description)
@section('keywords', $business->trans->tags)
@section('og_image', $business->getLogoLink())
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'businesses.review', $business))
@section('breadcrumbs', Breadcrumbs::render('businesses.review', $business))
@section('container', 'container-custom-xs')
@section('content')
    @php
        $stars = old('stars') ?? request('stars');
        $stars = $stars > 5 || $stars < 1 ? 0 : $stars;
    @endphp
    <form action="{{ route('businesses.review.store', $business->domain) }}" method="POST">
        @csrf
        <div
            class="item-box box {{ isAddonActive('ai_review_writer') && config('settings.ai_review_writer.status') ? 'ai-review-writer' : '' }}">
            <div class="item-box-body">
                <div class="row row-cols-1 g-4">
                    <div class="col">
                        <h5 class="fw-semibold mb-3">{{ d_trans('How would you rate your experience?') }}</h5>
                        <div class="ratings ratings-xxl ratings-selective">
                            <div class="rating {{ $stars >= 1 ? 'rating-active' : '' }}">
                                <i class="bi bi-star-fill"></i>
                                <input type="radio" name="stars" value="1" @checked($stars == 1)>
                            </div>
                            <div class="rating {{ $stars > 1 ? 'rating-active' : '' }}">
                                <i class="bi bi-star-fill"></i>
                                <input type="radio" name="stars" value="2" @checked($stars == 2)>
                            </div>
                            <div class="rating {{ $stars > 2 ? 'rating-active' : '' }}">
                                <i class="bi bi-star-fill"></i>
                                <input type="radio" name="stars" value="3" @checked($stars == 3)>
                            </div>
                            <div class="rating {{ $stars > 3 ? 'rating-active' : '' }}">
                                <i class="bi bi-star-fill"></i>
                                <input type="radio" name="stars" value="4" @checked($stars == 4)>
                            </div>
                            <div class="rating {{ $stars > 4 ? 'rating-active' : '' }}">
                                <i class="bi bi-star-fill"></i>
                                <input type="radio" name="stars" value="5" @checked($stars == 5)>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center mb-3">
                            <div class="col">
                                <h5 class="fw-semibold mb-0">
                                    {{ d_trans('What stood out during your experience?') }}
                                </h5>
                            </div>
                            @if (isAddonActive('ai_review_writer') && config('settings.ai_review_writer.status'))
                                <div class="col-auto">
                                    <div class="row g-2 row-cols-auto">
                                        <div class="col">
                                            <button type="button" class="btn btn-outline-primary btn-sm ai-writer-button"
                                                data-input="description"><i
                                                    class="bi bi-pencil me-2"></i>{{ d_trans('Use AI Writer') }}</button>
                                        </div>
                                        <div class="col d-none">
                                            <button type="button" class="btn btn-primary btn-sm ai-generate-button"
                                                data-input="description" data-default-content="{{ d_trans('Write') }}"
                                                data-action="{{ route('businesses.review.ai-review-writer', $business->domain) }}"><i
                                                    class="bi bi-pencil me-2"></i>{{ d_trans('Write') }}</button>
                                        </div>
                                        <div class="col d-none">
                                            <button type="button" class="btn btn-outline-secondary btn-sm ai-cancel-button"
                                                data-input="description"><i
                                                    class="bi bi-x-lg me-2"></i>{{ d_trans('Cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <textarea id="description" name="description" class="form-control py-3 fs-6" rows="6"
                            placeholder="{{ d_trans('Share your thoughts, what you liked or disliked...') }}"
                            @if (isAddonActive('ai_review_writer') && config('settings.ai_review_writer.status')) data-default-placeholder="{{ d_trans('Summarize your experience in a few words') }}"
                            data-ai-placeholder="{{ d_trans('What do you want AI to write about?') }}" @endif
                            minlength="60" maxlength="4000" autofocus required>{{ old('description') }}</textarea>
                    </div>
                    <div class="col">
                        <div class="row align-items-center mb-3">
                            <div class="col">
                                <h5 class="fw-semibold mb-0">{{ d_trans('Give your review a short title') }}</h5>
                            </div>
                            @if (isAddonActive('ai_review_writer') && config('settings.ai_review_writer.status'))
                                <div class="col-auto">
                                    <div class="row g-2 row-cols-auto">
                                        <div class="col">
                                            <button type="button" class="btn btn-outline-primary btn-sm ai-writer-button"
                                                data-input="title"><i
                                                    class="bi bi-pencil me-2"></i>{{ d_trans('Use AI Writer') }}</button>
                                        </div>
                                        <div class="col d-none">
                                            <button type="button" class="btn btn-primary btn-sm ai-generate-button"
                                                data-input="title" data-default-content="{{ d_trans('Write') }}"
                                                data-action="{{ route('businesses.review.ai-review-writer', $business->domain) }}"><i
                                                    class="bi bi-pencil me-2"></i>{{ d_trans('Write') }}</button>
                                        </div>
                                        <div class="col d-none">
                                            <button type="button" class="btn btn-outline-secondary btn-sm ai-cancel-button"
                                                data-input="title"><i
                                                    class="bi bi-x-lg me-2"></i>{{ d_trans('Cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <input id="title" type="text" name="title"
                            class="form-control ai-input form-control-md fs-6"
                            placeholder="{{ d_trans('Summarize your experience in a few words') }}"
                            @if (isAddonActive('ai_review_writer') && config('settings.ai_review_writer.status')) data-default-placeholder="{{ d_trans('Summarize your experience in a few words') }}"
                            data-ai-placeholder="{{ d_trans('What do you want AI to write about?') }}" @endif
                            value="{{ old('title') }}" maxlength="100" required />
                    </div>
                    <div class="col">
                        <h5 class="fw-semibold mb-3">{{ d_trans('When did this experience take place?') }}</h5>
                        <input type="date" name="experience_date" class="form-control form-control-md"
                            value="{{ old('experience_date') }}" required />
                    </div>
                    @if (config('settings.business.actions.reviews_require_login') || authUser())
                        <div class="col">
                            <small class="text-muted">
                                {{ d_trans("By submitting your review, you confirm it's honest, based on your own experience, and not influenced by any rewards or incentives.") }}
                            </small>
                        </div>
                        <x-captcha class="col" />
                        <div class="col">
                            <button class="btn btn-primary btn-md px-5">{{ d_trans('Submit') }}</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if (!config('settings.business.actions.reviews_require_login') && !authUser())
            <div class="item-box box mt-3">
                <div class="item-box-body">
                    <div class="row row-cols-1 g-4">
                        <div class="col">
                            <h5 class="fw-semibold mb-3">{{ d_trans('Your Name') }}</h5>
                            <input type="text" name="name" class="form-control form-control-md fs-6"
                                placeholder="{{ d_trans('Enter your name') }}" value="{{ old('name') }}" required />
                        </div>
                        <div class="col">
                            <h5 class="fw-semibold mb-3">{{ d_trans('Your Email Address') }}</h5>
                            <input type="email" name="email" class="form-control form-control-md fs-6"
                                placeholder="{{ d_trans('Enter your email address') }}" value="{{ old('email') }}"
                                required />
                        </div>
                        <div class="col">
                            <small class="text-muted">
                                {{ d_trans("By submitting your review, you confirm it's honest, based on your own experience, and not influenced by any rewards or incentives.") }}
                            </small>
                        </div>
                        <x-captcha class="col" />
                        <div class="col">
                            <button class="btn btn-primary btn-md px-5">{{ d_trans('Submit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/autosize/autosize.min.js') }}"></script>
    @endpush
@endsection
