@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('title', d_trans('Account Settings'))
@section('header_title', d_trans('Account Settings'))
@section('content')
    <div class="row row-cols-1 g-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span>{{ d_trans('Account Details') }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.account.settings.details') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="attach-img">
                            <div class="row g-3 align-items-center mb-4">
                                <div class="col-auto">
                                    <img src="{{ $admin->getAvatar() }}" alt="{{ $admin->getName() }}"
                                        class="attach-img-preview rounded-3 border" width="60px" height="60px">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-soft btn-sm attach-img-button"><i
                                            class="fas fa-camera me-2"></i>{{ d_trans('Choose Image') }}</button>
                                    <input type="file" name="avatar" class="attach-img-input"
                                        accept="image/png, image/jpg, image/jpeg" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('First Name') }} </label>
                                <input type="firstname" class="form-control  form-control-md" name="firstname"
                                    value="{{ $admin->firstname }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Last Name') }} </label>
                                <input type="lastname" class="form-control  form-control-md" name="lastname"
                                    value="{{ $admin->lastname }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Username') }} </label>
                                <input type="text" name="username" class="form-control form-control-md"
                                    value="{{ $admin->username }}" minlength="3" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Email Address') }} </label>
                                <input type="email" class="form-control  form-control-md" name="email"
                                    value="{{ $admin->email }}" required>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span>{{ d_trans('Change Password') }}</span>
                </div>
                <div class="card-body">
                    <form id="vironeer-submited-form" action="{{ route('admin.account.settings.password') }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Password') }} </label>
                            <input type="password" class="form-control  form-control-md" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('New Password') }} </label>
                            <input type="password" class="form-control  form-control-md" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Confirm New Password') }} </label>
                            <input type="password" class="form-control  form-control-md" name="new_password_confirmation"
                                required>
                        </div>
                        <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ d_trans('Two-Factor Authentication') }}</span>
                    @if (!$admin->two_factor_status)
                        <span class="badge bg-danger">{{ d_trans('Disabled') }}</span>
                    @else
                        <span class="badge bg-success">{{ d_trans('Enabled') }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        {{ d_trans('Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
                    </p>
                    <div class="my-3">
                        @if ($admin->isTwoFactorDisabled())
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-lg-auto">
                                    {!! $admin->getTwoFactorQrCode() !!}
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="input-group mb-3">
                                        <input id="input-secret" type="text" class="form-control form-control-md"
                                            value="{{ $admin->two_factor_secret }}" readonly>
                                        <button class="btn btn-soft px-3 btn-copy" data-clipboard-target="#input-secret"><i
                                                class="far fa-clone"></i></button>
                                    </div>
                                    <button class="btn btn-primary btn-md w-100" data-bs-toggle="modal"
                                        data-bs-target="#enable2FAModal">{{ d_trans('Enable 2FA Authentication') }}</button>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-5">
                                <button class="btn btn-danger btn-md w-100" data-bs-toggle="modal"
                                    data-bs-target="#disable2FAModal">{{ d_trans('Disable 2FA Authentication') }}</button>
                            </div>
                        @endif
                    </div>
                    <p class="mb-2">
                        {{ d_trans('To use the two factor authentication, you have to install a Google Authenticator compatible app. Here are some that are currently available:') }}
                    </p>
                    <li class="mb-1"><a target="_blank"
                            href="https://apps.apple.com/us/app/google-authenticator/id388497605">{{ d_trans('Google Authenticator for iOS') }}</a>
                    </li>
                    <li class="mb-1"><a target="_blank"
                            href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&gl=US">{{ d_trans('Google Authenticator for Android') }}</a>
                    </li>
                    <li class="mb-1"><a target="_blank"
                            href="https://apps.apple.com/us/app/microsoft-authenticator/id983156458">{{ d_trans('Microsoft Authenticator for iOS') }}</a>
                    </li>
                    <li class="mb-1"><a target="_blank"
                            href="https://play.google.com/store/apps/details?id=com.azure.authenticator&hl=en_US&gl=US">{{ d_trans('Microsoft Authenticator for Android') }}</a>
                    </li>
                </div>
            </div>
        </div>
    </div>
    @if ($admin->isTwoFactorDisabled())
        <div class="modal fade" id="enable2FAModal" tabindex="-1" aria-labelledby="enable2FAModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header p-0 mb-3 border-0">
                        <h1 class="modal-title fs-5" id="enable2FAModalLabel">{{ d_trans('OTP Code') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <form action="{{ route('admin.account.settings.2fa.enable') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="otp_code" class="form-control form-control-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-primary btn-md w-100"
                                        data-bs-dismiss="modal" aria-label="Close">{{ d_trans('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button class="btn btn-primary btn-md w-100">{{ d_trans('Enable') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="disable2FAModal" tabindex="-1" aria-labelledby="disable2FAModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header p-0 mb-3 border-0">
                        <h1 class="modal-title fs-5" id="disable2FAModalLabel">{{ d_trans('OTP Code') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <form action="{{ route('admin.account.settings.2fa.disable') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="otp_code" class="form-control form-control-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-danger btn-md w-100"
                                        data-bs-dismiss="modal" aria-label="Close">{{ d_trans('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button class="btn btn-danger btn-md w-100">{{ d_trans('Disable') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
