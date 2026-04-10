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
                <h5 class="settings-content-title">{{ d_trans('2Factor Authentication') }}</h5>
            </div>
            <div class="settings-content-body">
                <p class="text-muted">
                    {{ d_trans('Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
                </p>
                <div class="my-3">
                    <div class="row g-3 align-items-center">
                        @if ($businessOwner->isTwoFactorDisabled())
                            <div class="col-12 col-xl-auto">
                                <div class="text-center mb-2">
                                    {!! $businessOwner->getTwoFactorQrCode() !!}
                                </div>
                            </div>
                            <div class="col-12 col-xl-4">
                                <div class="input-group mb-3">
                                    <input id="input-link" type="text" class="form-control form-control-md "
                                        value="{{ $businessOwner->two_factor_secret }}" readonly>
                                    <button class="btn btn-outline-primary btn-md btn-copy"
                                        data-clipboard-target="#input-link"><i class="far fa-clone"></i></button>
                                </div>
                                <button class="btn btn-primary btn-md w-100 " data-bs-toggle="modal"
                                    data-bs-target="#towfactorModal">{{ d_trans('Enable 2FA Authentication') }}</button>
                            </div>
                        @else
                            <div class="col-12 col-xl-4">
                                <button class="btn btn-danger btn-md w-100 " data-bs-toggle="modal"
                                    data-bs-target="#towfactorDisableModal">{{ d_trans('Disable 2FA Authentication') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
                <p class="text-muted mb-2">
                    {{ d_trans('To use the two factor authentication, you have to install a Google Authenticator compatible app. Here are some that are currently available:') }}
                </p>
                @include('themes.basic.partials.2fa-links')
            </div>
        </div>
    </div>
    @if ($businessOwner->isTwoFactorDisabled())
        <div class="modal fade" id="towfactorModal" aria-labelledby="towfactorModalLabel" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title" id="createFolderModalLabel">{{ d_trans('OTP Code') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('business.account.settings.2fa.enable') }}" method="POST">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="mb-4">
                                <input type="text" name="otp_code" class="form-control form-control-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-primary btn-md w-100"
                                        data-bs-dismiss="modal">{{ d_trans('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button type="submit"
                                        class="btn btn-primary btn-md w-100 ">{{ d_trans('Enable') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="towfactorDisableModal" tabindex="-1" aria-labelledby="towfactorDisableModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title" id="createFolderModalLabel">{{ d_trans('OTP Code') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('business.account.settings.2fa.disable') }}" method="POST">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="mb-4">
                                <input type="text" name="otp_code" class="form-control form-control-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-danger btn-md w-100"
                                        data-bs-dismiss="modal">{{ d_trans('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button type="submit"
                                        class="btn btn-danger btn-md w-100">{{ d_trans('Disable') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
