@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-md')
@section('title', d_trans('Settings'))
@section('header_title', d_trans('Business Settings'))
@section('breadcrumbs', Breadcrumbs::render('business.settings'))
@section('hide_alerts', true)
@section('content')
    <div class="dashboard-accordion accordion" id="accordion">
        <div class="accordion-item mb-4">
            <h2 class="accordion-header position-relative">
                <button class="accordion-button position-relative" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordion1" aria-expanded="true" aria-controls="accordion1">
                    {{ d_trans('Business Details') }}
                    @if (!$currentBusiness->hasDataCompleted())
                        @if ($currentBusiness->hasDetailsCompleted())
                            <i class="far fa-check-circle text-success status-icon"></i>
                        @else
                            <i class="far fa-question-circle text-warning status-icon"></i>
                        @endif
                    @endif
                </button>
            </h2>
            <div id="accordion1" class="accordion-collapse collapse show" data-bs-parent="#accordion">
                <div class="accordion-body p-4">
                    <form action="{{ route('business.settings.details.update') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Business Name') }}</label>
                                <input type="text" name="business_name" class="form-control form-control-md"
                                    value="{{ $currentBusiness->name }}" required />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Website') }}</label>
                                <input type="url" name="website" class="form-control form-control-md"
                                    placeholder="https://example.com" value="{{ $currentBusiness->website }}" required />
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Category') }}</label>
                                <select name="category" class="form-select form-select-md" required>
                                    <option value="" disabled selected>{{ d_trans('Select Category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($currentBusiness->category_id == $category->id)>
                                            {{ $category->trans->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Email') }}</label>
                                <input type="email" name="email" class="form-control form-control-md"
                                    value="{{ demo($currentBusiness->email) }}" />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Phone Number') }}</label>
                                <input type="mobile" name="phone_number" class="form-control form-control-md"
                                    value="{{ $currentBusiness->phone }}" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Short Description') }}</label>
                                <textarea name="short_description" class="form-control form-control-md"
                                    placeholder="{{ d_trans('Between 30 to 60 characters') }}" rows="3" minlength="30" maxlength="60" required>{{ $currentBusiness->short_description }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Full Description') }}</label>
                                <textarea name="description" class="form-control form-control-md" placeholder="{{ d_trans('Max 1500 characters') }}"
                                    rows="10">{{ $currentBusiness->description }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Tags') }}</label>
                                <input id="businessTags" type="text" name="tags"
                                    value="{{ $currentBusiness->tags }}">
                                <div class="form-text">
                                    {{ d_trans('Add relevant tags to help improve search visibility and make it easier for people to find your business quickly') }}
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
                <button class="accordion-button position-relative collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordion2" aria-expanded="true" aria-controls="accordion2">
                    {{ d_trans('Business Logo') }}
                    @if (!$currentBusiness->hasDataCompleted())
                        @if ($currentBusiness->hasLogoCompleted())
                            <i class="far fa-check-circle text-success status-icon"></i>
                        @else
                            <i class="far fa-question-circle text-warning status-icon"></i>
                        @endif
                    @endif
                </button>
            </h2>
            <div id="accordion2" class="accordion-collapse collapse" data-bs-parent="#accordion">
                <div class="accordion-body p-4">
                    <form action="{{ route('business.settings.logo.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center g-3 attach-img mb-3">
                            <div class="col-auto">
                                <img src="{{ $currentBusiness->getLogoLink() }}" alt="{{ $currentBusiness->trans->name }}"
                                    class="attach-img-preview border rounded-3 p-2" width="120px" height="120px">
                            </div>
                            <div class="col">
                                <div class="mb-2">
                                    <button type="button" class="btn btn-light attach-img-button">
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
                <button class="accordion-button position-relative collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordion3" aria-expanded="true" aria-controls="accordion3">
                    {{ d_trans('Business Social Links') }}
                    @if (!$currentBusiness->hasDataCompleted())
                        @if ($currentBusiness->hasSocialLinksCompleted())
                            <i class="far fa-check-circle text-success status-icon"></i>
                        @else
                            <i class="far fa-question-circle text-warning status-icon"></i>
                        @endif
                    @endif
                </button>
            </h2>
            <div id="accordion3" class="accordion-collapse collapse" data-bs-parent="#accordion">
                <div class="accordion-body p-4">
                    <form action="{{ route('business.settings.social-links.update') }}" method="POST">
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
                                            class="form-control form-control-md" placeholder="{{ d_trans('Username') }}"
                                            value="{{ @$currentBusiness->social_links->facebook }}">
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
                                        <input type="text" name="social_links[x]" class="form-control form-control-md"
                                            placeholder="{{ d_trans('Username') }}"
                                            value="{{ @$currentBusiness->social_links->x }}">
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
                                            class="form-control form-control-md" placeholder="{{ d_trans('Username') }}"
                                            value="{{ @$currentBusiness->social_links->youtube }}">
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
                                            class="form-control form-control-md" placeholder="{{ d_trans('Username') }}"
                                            value="{{ @$currentBusiness->social_links->linkedin }}">
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
                                            class="form-control form-control-md" placeholder="{{ d_trans('Username') }}"
                                            value="{{ @$currentBusiness->social_links->instagram }}">
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
                                            class="form-control form-control-md" placeholder="{{ d_trans('Username') }}"
                                            value="{{ @$currentBusiness->social_links->pinterest }}">
                                    </div>
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
                <button class="accordion-button position-relative collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordion4" aria-expanded="true" aria-controls="accordion4">
                    {{ d_trans('Business Address') }}
                    @if (!$currentBusiness->hasDataCompleted())
                        @if ($currentBusiness->hasAddressCompleted())
                            <i class="far fa-check-circle text-success status-icon"></i>
                        @else
                            <i class="far fa-question-circle text-warning status-icon"></i>
                        @endif
                    @endif
                </button>
            </h2>
            <div id="accordion4" class="accordion-collapse collapse" data-bs-parent="#accordion">
                <div class="accordion-body p-4">
                    <form action="{{ route('business.settings.address.update') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-lg-6">
                                <label class="form-label">{{ d_trans('Address line 1') }}</label>
                                <input type="text" name="address_line_1" class="form-control form-control-md"
                                    value="{{ $currentBusiness->address_line_1 }}">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">{{ d_trans('Address line 2') }}</label>
                                <input type="text" name="address_line_2" class="form-control form-control-md"
                                    value="{{ $currentBusiness->address_line_2 }}">
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label">{{ d_trans('City') }}</label>
                                <input type="text" name="city" class="form-control form-control-md"
                                    value="{{ $currentBusiness->city }}">
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label">{{ d_trans('State') }}</label>
                                <input type="text" name="state" class="form-control form-control-md"
                                    value="{{ $currentBusiness->state }}">
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ d_trans('Postal code') }}</label>
                                    <input type="text" name="zip" class="form-control form-control-md"
                                        value="{{ $currentBusiness->zip }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Country') }}</label>
                                <select name="country" class="form-select form-select-md">
                                    <option value="">--</option>
                                    @foreach (countries() as $countryCode => $countryName)
                                        <option value="{{ $countryCode }}" @selected($currentBusiness->country == $countryCode)>
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
        <div class="accordion-item mb-4">
            <h2 class="accordion-header position-relative">
                <button class="accordion-button position-relative collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordion5" aria-expanded="true" aria-controls="accordion5">
                    {{ d_trans('Business Domain Verification') }}
                    @if (!$currentBusiness->hasDataCompleted())
                        @if ($currentBusiness->isVerified())
                            <i class="far fa-check-circle text-success status-icon"></i>
                        @else
                            <i class="far fa-question-circle text-warning status-icon"></i>
                        @endif
                    @endif
                </button>
            </h2>
            <div id="accordion5" class="accordion-collapse collapse" data-bs-parent="#accordion">
                <div class="accordion-body p-4">
                    @if ($currentBusiness->isUnverified())
                        <h4>{{ d_trans('Verify your domain ownership') }}</h4>
                        <p class="mb-2">
                            {{ d_trans('Verifying your domain helps build trust and ensures your business appears more credible to visitors.') }}
                        </p>
                        <p class="mb-1 fw-bold">{{ d_trans('To verify your domain, follow these steps:') }}</p>
                        <ul class="mb-3 ps-3">
                            <li>{{ d_trans('Go to your domain DNS settings.') }}</li>
                            <li>{{ d_trans('Add a new TXT record with the following details:') }}</li>
                        </ul>
                        <div class="mb-3 bg-light p-3 rounded border text-dark">
                            <p class="mb-1"><strong>{{ d_trans('Type:') }}</strong> TXT</p>
                            <p class="mb-1"><strong>{{ d_trans('Name/Host:') }}</strong> @</p>
                            <p class="mb-0"><strong>{{ d_trans('Value:') }}</strong>
                                {{ $currentBusiness->getDomainVerificationKey() }}</p>
                        </div>
                        <p class="mb-3">
                            {{ d_trans('Once added, click verify now to check and please note that it may take a few minutes for changes to propagate') }}
                        </p>
                        <div class="row g-3 row-cols-auto">
                            <div class="col">
                                <form action="{{ route('business.settings.verify') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-md action-confirm px-4">
                                        <i class="fa-solid fa-check me-2"></i>{{ d_trans('Verify Now') }}
                                    </button>
                                </form>
                            </div>
                            @if (config('settings.actions.contact_page') && config('settings.general.contact_email'))
                                <div class="col">
                                    <a href="{{ route('contact') }}"
                                        class="btn btn-outline-dark btn-md px-4">{{ d_trans('Need Help?') }}</a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-success mb-0">
                            <p class="mb-0"><i
                                    class="bi bi-patch-check me-2"></i>{{ d_trans('Your business domain has been verified') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if (authBusinessOwner()->isSuperAdminOfCurrentBusiness())
            <div class="accordion-item">
                <h2 class="accordion-header position-relative">
                    <button class="accordion-button position-relative collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#accordion6" aria-expanded="true" aria-controls="accordion6">
                        {{ d_trans('Business Deletion') }}
                    </button>
                </h2>
                <div id="accordion6" class="accordion-collapse collapse" data-bs-parent="#accordion">
                    <div class="accordion-body p-4">
                        <p>
                            {{ d_trans('After deleting your business, you will lose all your reviews and settings and will not be able to restore them') }}
                        </p>
                        <form action="{{ route('business.settings.delete') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger action-confirm btn-md">{{ d_trans('Delete business') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
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
        <script>
            "use strict";
            let businessTags = $('#businessTags');
            if (businessTags.length) {
                console.log(444)
                businessTags.tagsinput({
                    cancelConfirmKeysOnEmpty: false,
                    maxTags: 15,
                });
            }
        </script>
    @endpush
@endsection
