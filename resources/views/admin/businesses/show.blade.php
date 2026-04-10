@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Businesses'))
@section('title', d_trans('Business Details'))
@section('header_title', d_trans(':business_name Details', ['business_name' => $business->trans->name]))
@section('back', route('admin.businesses.index'))
@section('business_view', true)
@section('content')
    @include('admin.businesses.includes.tabs')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="custom-accordion accordion" id="accordion">
                <div class="accordion-item mb-4">
                    <h2 class="accordion-header position-relative">
                        <button class="accordion-button position-relative" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion1" aria-expanded="true" aria-controls="accordion1">
                            {{ d_trans('Business Details') }}
                        </button>
                    </h2>
                    <div id="accordion1" class="accordion-collapse collapse show" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <form action="{{ route('admin.businesses.details.update', $business->id) }}" method="POST">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Business Name') }}</label>
                                        <input type="text" name="business_name" class="form-control form-control-md"
                                            value="{{ $business->trans->name }}" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Website') }}</label>
                                        <div class="input-group">
                                            <input type="url" name="website" class="form-control form-control-md"
                                                value="{{ $business->website }}" />
                                            <button type="button" class="btn btn-outline-secondary icon-rtl px-3"
                                                onclick="window.open('{{ $business->website }}', '_blank')">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ d_trans('Category') }}</label>
                                        <select name="category" class="form-select form-select-md" required>
                                            <option value="" disabled selected>{{ d_trans('Select Category') }}
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected($business->category_id == $category->id)>
                                                    {{ $category->trans->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Email') }}</label>
                                        <input type="email" name="email" class="form-control form-control-md"
                                            value="{{ demo($business->email) }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Phone Number') }}</label>
                                        <input type="mobile" name="phone_number" class="form-control form-control-md"
                                            value="{{ $business->phone }}" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ d_trans('Short Description') }}</label>
                                        <textarea name="short_description" class="form-control form-control-md"
                                            placeholder="{{ d_trans('Between 30 to 60 characters') }}" rows="3" minlength="30" maxlength="60" required>{{ $business->short_description }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ d_trans('Full Description') }}</label>
                                        <textarea name="description" class="form-control form-control-md" placeholder="{{ d_trans('Max 1500 characters') }}"
                                            rows="10">{{ $business->description }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ d_trans('Tags') }}</label>
                                        <div class="tagsinput tagsinput-md">
                                            <input type="text" name="tags" value="{{ $business->tags }}"
                                                class="form-control form-control-md tags-input">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-4">
                    <h2 class="accordion-header position-relative">
                        <button class="accordion-button position-relative collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion2" aria-expanded="true"
                            aria-controls="accordion2">
                            {{ d_trans('Business Logo') }}
                        </button>
                    </h2>
                    <div id="accordion2" class="accordion-collapse collapse" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <form action="{{ route('admin.businesses.logo.update', $business->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row align-items-center g-3 attach-img mb-3">
                                    <div class="col-auto">
                                        <img src="{{ $business->getLogoLink() }}" alt="{{ $business->trans->name }}"
                                            class="attach-img-preview border rounded-3 p-2" width="120px" height="120px">
                                    </div>
                                    <div class="col">
                                        <div class="mb-2">
                                            <button type="button" class="btn btn-soft attach-img-button">
                                                <i class="fa fa-camera me-2"></i>{{ d_trans('Choose Logo') }}
                                            </button>
                                            <input type="file" name="logo" class="attach-img-input"
                                                accept="image/png, image/jpg, image/jpeg" required hidden>
                                        </div>
                                        <div class="col-lg-6">
                                            <small class="text-muted">
                                                {{ d_trans('Supported types: JPEG, JPG, and PNG. Image dimensions must 512x512 pixels and not exceed 2MB.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-4">
                    <h2 class="accordion-header position-relative">
                        <button class="accordion-button position-relative collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion3" aria-expanded="true"
                            aria-controls="accordion3">
                            {{ d_trans('Business Social Links') }}
                        </button>
                    </h2>
                    <div id="accordion3" class="accordion-collapse collapse" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <form action="{{ route('admin.businesses.social-links.update', $business->id) }}"
                                method="POST">
                                @csrf
                                <div class="row g-3 mb-4">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Facebook') }}</label>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <button type="button" class="social-btn social-facebook p-4">
                                                    <i class="fab fa-facebook-f"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="social_links[facebook]"
                                                    class="form-control form-control-md"
                                                    placeholder="{{ d_trans('Username') }}"
                                                    value="{{ @$business->social_links->facebook }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('X.com') }}</label>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <button type="button" class="social-btn social-x p-4">
                                                    <i class="fab fa-x-twitter"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="social_links[x]"
                                                    class="form-control form-control-md"
                                                    placeholder="{{ d_trans('Username') }}"
                                                    value="{{ @$business->social_links->x }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Youtube') }}</label>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <button type="button" class="social-btn social-youtube p-4">
                                                    <i class="fab fa-youtube"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="social_links[youtube]"
                                                    class="form-control form-control-md"
                                                    placeholder="{{ d_trans('Username') }}"
                                                    value="{{ @$business->social_links->youtube }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Linkedin') }}</label>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <button type="button" class="social-btn social-linkedin p-4">
                                                    <i class="fab fa-linkedin"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="social_links[linkedin]"
                                                    class="form-control form-control-md"
                                                    placeholder="{{ d_trans('Username') }}"
                                                    value="{{ @$business->social_links->linkedin }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Instagram') }}</label>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <button type="button" class="social-btn social-instagram p-4">
                                                    <i class="fab fa-instagram"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="social_links[instagram]"
                                                    class="form-control form-control-md"
                                                    placeholder="{{ d_trans('Username') }}"
                                                    value="{{ @$business->social_links->instagram }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ d_trans('Pinterest') }}</label>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <button type="button" class="social-btn social-pinterest p-4">
                                                    <i class="fab fa-pinterest"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="social_links[pinterest]"
                                                    class="form-control form-control-md"
                                                    placeholder="{{ d_trans('Username') }}"
                                                    value="{{ @$business->social_links->pinterest }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header position-relative">
                        <button class="accordion-button position-relative collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion4" aria-expanded="true"
                            aria-controls="accordion4">
                            {{ d_trans('Business Address') }}
                        </button>
                    </h2>
                    <div id="accordion4" class="accordion-collapse collapse" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <form action="{{ route('admin.businesses.address.update', $business->id) }}" method="POST">
                                @csrf
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-lg-6">
                                        <label class="form-label">{{ d_trans('Address line 1') }}</label>
                                        <input type="text" name="address_line_1" class="form-control form-control-md"
                                            value="{{ $business->address_line_1 }}">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label class="form-label">{{ d_trans('Address line 2') }}</label>
                                        <input type="text" name="address_line_2" class="form-control form-control-md"
                                            value="{{ $business->address_line_2 }}">
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="form-label">{{ d_trans('City') }}</label>
                                        <input type="text" name="city" class="form-control form-control-md"
                                            value="{{ $business->city }}">
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="form-label">{{ d_trans('State') }}</label>
                                        <input type="text" name="state" class="form-control form-control-md"
                                            value="{{ $business->state }}">
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ d_trans('Postal code') }}</label>
                                            <input type="text" name="zip" class="form-control form-control-md"
                                                value="{{ $business->zip }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ d_trans('Country') }}</label>
                                        <select name="country" class="form-select form-select-md">
                                            <option value="">--</option>
                                            @foreach (countries() as $countryCode => $countryName)
                                                <option value="{{ $countryCode }}" @selected($business->country == $countryCode)>
                                                    {{ $countryName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item pb-4 text-center">
                            <div class="mb-2">
                                <img src="{{ $business->getLogoLink() }}" alt="{{ $business->trans->name }}"
                                    class="border rounded-circle p-2" width="100px" height="100px">
                            </div>
                            <h4>{{ $business->trans->name }}</h4>
                            <div>
                                <img src="{{ $business->getAvgRatingImageLink() }}" alt="{{ $business->avg_ratings }}"
                                    width="100px">
                                <span class="ms-1"><strong>{{ $business->avg_ratings }}</strong>
                                    ({{ translate_choice(':count Review|:count Reviews', $business->total_reviews, ['count' => numberFormat($business->total_reviews)]) }})
                                </span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex g-3 p-0 py-3">
                            <div class="col">
                                <strong>{{ d_trans('Name') }}</strong>
                            </div>
                            <div class="col-auto">{{ $business->trans->name }}</div>
                        </li>
                        <li class="list-group-item d-flex g-3 p-0 py-3">
                            <div class="col">
                                <strong>{{ d_trans('Website') }}</strong>
                            </div>
                            <div class="col-auto">
                                <a href="{{ $business->website }}" target="_blank">{{ $business->website }}</a>
                            </div>
                        </li>
                        @if ($business->hasCategory())
                            <li class="list-group-item d-flex g-3 p-0 py-3">
                                <div class="col">
                                    <strong>{{ d_trans('Category') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.categories.edit', $business->category->id) }}"
                                        target="_blank" class="text-dark">{{ $business->category->trans->name }}</a>
                                </div>
                            </li>
                        @endif
                        @if ($business->hasOwner())
                            <li class="list-group-item d-flex g-3 p-0 py-3">
                                <div class="col">
                                    <strong>{{ d_trans('Owner') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.members.business-owners.edit', $business->owner->id) }}"
                                        class="text-dark"><i
                                            class="fa fa-user me-2"></i>{{ $business->owner->getName() }}</a>
                                </div>
                            </li>
                        @endif
                        <li class="list-group-item d-flex g-3 p-0 py-3">
                            <div class="col">
                                <strong>{{ d_trans('Verification') }}</strong>
                            </div>
                            <div class="col-auto">
                                @if ($business->isVerified())
                                    <span class="badge bg-c-26">{{ $business->getVerificationStatusName() }}</span>
                                @else
                                    <span class="badge bg-c20">{{ $business->getVerificationStatusName() }}</span>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item d-flex g-3 p-0 py-3">
                            <div class="col">
                                <strong>{{ d_trans('Status') }}</strong>
                            </div>
                            <div class="col-auto">
                                @if ($business->isActive())
                                    <span class="badge bg-success">{{ $business->getStatusName() }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $business->getStatusName() }}</span>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item p-0 py-3">
                            <div class="row g-3">
                                @if ($business->isActive())
                                    <div class="col-12">
                                        <a href="{{ $business->getLink() }}" target="_blank"
                                            class="btn btn-outline-secondary btn-md w-100"><i
                                                class="fas fa-external-link-alt me-2"></i>{{ d_trans('View Business') }}</a>
                                    </div>
                                @endif
                                @if ($business->isFeatured())
                                    <div class="col-12">
                                        <form action="{{ route('admin.businesses.featured.remove', $business->id) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-md w-100 action-confirm"><i
                                                    class="fa-solid fa-certificate me-2"></i>{{ d_trans('Remove Featured') }}</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <form action="{{ route('admin.businesses.featured.make', $business->id) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-primary btn-md w-100 action-confirm"><i
                                                    class="fa-solid fa-certificate me-2"></i>{{ d_trans('Make Featured') }}</button>
                                        </form>
                                    </div>
                                @endif
                                @if ($business->isActive())
                                    <div class="col-12">
                                        <form action="{{ route('admin.businesses.suspend', $business->id) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger btn-md w-100 action-confirm"><i
                                                    class="fa-solid fa-ban me-2"></i>{{ d_trans('Suspend') }}</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <form action="{{ route('admin.businesses.activate', $business->id) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-outline-success btn-md w-100 action-confirm"><i
                                                    class="fa-solid fa-check me-2"></i>{{ d_trans('Activate') }}</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
    @endpush
    @push('scripts')
        @if (session('accordion_id'))
            <script>
                "use strict";
                const accordionId = '{{ session('accordion_id') }}';
                if (accordionId) {
                    const $targetAccordion = $('#' + accordionId);
                    const targetAccordion = $targetAccordion[0];
                    if ($targetAccordion.hasClass('collapse') && !$targetAccordion.hasClass('show')) {
                        $('button[data-bs-target="#' + accordionId + '"]').trigger('click');
                        const yOffset = -300;
                        const y = targetAccordion.getBoundingClientRect().top + window.pageYOffset + yOffset;
                        window.scrollTo({
                            top: y,
                            behavior: 'smooth'
                        });
                    }
                }
            </script>
        @endif
    @endpush
@endsection
