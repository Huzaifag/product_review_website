@extends('themes.basic.business.layouts.app')
@section('hide_alerts', true)
@section('title', d_trans('Account Settings'))
@section('header_title', d_trans('Account Settings'))
@section('breadcrumbs', Breadcrumbs::render('business.account.settings'))
@section('content')
    <div class="settings-box">
        @include('themes.basic.business.account.settings.includes.sidebar')
        <div class="settings-content">
            <div class="settings-content-header">
                <h5 class="settings-content-title">{{ d_trans('KYC Verification') }}</h5>
            </div>
            <div class="settings-content-body">
                @if ($businessOwner->hasKycVerified())
                    <div class="col-lg-7 m-auto py-5">
                        @include('themes.basic.partials.kyc-verified')
                    </div>
                @elseif($businessOwner->hasKycPending())
                    <div class="col-lg-7 m-auto py-5">
                        @include('themes.basic.partials.kyc-pending')
                    </div>
                @else
                    <form action="{{ route('business.account.settings.kyc.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-cols-1 g-4">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">{{ d_trans('ID Verification') }}</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-4">
                                            <div class="col-12 col-lg-12 col-xxl-5">
                                                <div class="mb-4">
                                                    <p>
                                                        {{ d_trans('Upload a clear, legible image and Ensure that all relevant details, such as your name, photo, and ID number, are visible. the image must be type of .JPG or .PNG') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="form-label">{{ d_trans('Document type') }}</label>
                                                    <select id="kycDocument" name="document_type"
                                                        class="form-select form-select-md rounded-3">
                                                        <option value="national_id">{{ d_trans('National ID') }}</option>
                                                        <option value="passport">{{ d_trans('Passport') }}</option>
                                                    </select>
                                                </div>
                                                <div id="nationalIDNumber" class="mt-4">
                                                    <label class="form-label">{{ d_trans('National ID Number') }}</label>
                                                    <input type="text" name="national_id_number"
                                                        class="form-control form-control-md"
                                                        value="{{ old('national_id_number') }}" autofocus>
                                                </div>
                                                <div id="passportNumber" class="mt-4 d-none">
                                                    <label class="form-label">{{ d_trans('Passport Number') }}</label>
                                                    <input type="text" name="passport_number"
                                                        class="form-control form-control-md"
                                                        value="{{ old('passport_number') }}" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-12 col-xxl-7">
                                                <div id="nationalId" class="row g-3">
                                                    <div class="col-md-6 col-lg-6">
                                                        <div class="attach-img border rounded-3 p-3">
                                                            <h6 class="mb-3">{{ d_trans('Front Of ID') }}</h6>
                                                            <div class="mb-3">
                                                                <img src="{{ asset(config('settings.kyc.media.id_front_image')) }}"
                                                                    class="attach-img-preview" width="100%"
                                                                    height="200px">
                                                            </div>
                                                            <input type="file" name="front_of_id"
                                                                class="form-control form-control-md attach-img-input rounded-3"
                                                                accept=".jpeg, .jpg, .png">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6">
                                                        <div class="attach-img border rounded-3 p-3">
                                                            <h6 class="mb-3">{{ d_trans('Back Of ID') }}</h6>
                                                            <div class="mb-3">
                                                                <img src="{{ asset(config('settings.kyc.media.id_back_image')) }}"
                                                                    class="attach-img-preview" width="100%"
                                                                    height="200px">
                                                            </div>
                                                            <input type="file" name="back_of_id"
                                                                class="form-control form-control-md attach-img-input rounded-3"
                                                                accept=".jpeg, .jpg, .png">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="passport" class="row g-3 justify-content-lg-center d-none">
                                                    <div class="col-lg-7">
                                                        <div class="attach-img border rounded-3 p-3">
                                                            <h6 class="mb-3">{{ d_trans('Passport') }}</h6>
                                                            <div class="mb-3">
                                                                <img src="{{ asset(config('settings.kyc.media.passport_image')) }}"
                                                                    class="attach-img-preview" width="100%"
                                                                    height="300px">
                                                            </div>
                                                            <input type="file" name="passport"
                                                                class="form-control form-control-md attach-img-input rounded-3"
                                                                accept=".jpeg, .jpg, .png">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (config('settings.kyc.actions.selfie_verification'))
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">{{ d_trans('Selfie Verification') }}</h5>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-4">
                                                <div class="col-lg-9">
                                                    <p>
                                                        {{ d_trans("Upload a clear selfie and Ensure it's well-lit and visible. the image must be type of.JPG or .PNG") }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="d-flex justify-content-lg-center">
                                                        <div class="attach-img border rounded-3 p-3">
                                                            <div class="mb-3">
                                                                <img src="{{ asset(config('settings.kyc.media.selfie_image')) }}"
                                                                    class="attach-img-preview" width="100%"
                                                                    height="250px">
                                                            </div>
                                                            <input type="file" id="selfie" name="selfie"
                                                                class="form-control form-control-md attach-img-input rounded-3"
                                                                data-id="3" accept=".jpg,.jpeg,.png">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col">
                                <button class="btn btn-primary btn-md ">{{ d_trans('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
