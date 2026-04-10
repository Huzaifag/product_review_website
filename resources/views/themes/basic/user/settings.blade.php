@extends('themes.basic.user.layout')
@section('no_index', true)
@section('title', d_trans('Settings'))
@section('header_title', d_trans('Settings'))
@section('breadcrumbs', Breadcrumbs::render('user.settings', $user))
@section('content')
    <div class="card mb-4">
        <div class="card-header fw-medium">{{ d_trans('Account Details') }}</div>
        <div class="card-body p-4">
            <form action="{{ route('user.settings.update', $user->username) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-lg-12">
                        <div class="row align-items-center attach-img">
                            <div class="col-auto">
                                <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}"
                                    class="attach-img-preview rounded-circle border" width="80px" height="80px">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-light attach-img-button"><i
                                        class="fas fa-camera me-2"></i>{{ d_trans('Choose Avatar') }}</button>
                                <input type="file" name="avatar" class="attach-img-input"
                                    accept="image/png, image/jpg, image/jpeg" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('First Name') }} </label>
                        <input type="firstname" name="firstname" class="form-control form-control-md"
                            value="{{ $user->firstname }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Last Name') }} </label>
                        <input type="lastname" name="lastname" class="form-control form-control-md"
                            value="{{ $user->lastname }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Username') }} </label>
                        <input type="text" name="username" class="form-control form-control-md"
                            value="{{ $user->username }}" minlength="3" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Email Address') }} </label>
                        <input type="email" name="email" class="form-control form-control-md"
                            value="{{ demo($user->email) }}" required>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ d_trans('Country') }}</label>
                        <select name="country" class="form-select form-select-md">
                            <option value="">--</option>
                            @foreach (countries() as $countryCode => $countryName)
                                <option value="{{ $countryCode }}" @selected($user->country == $countryCode)>
                                    {{ $countryName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header fw-medium">{{ d_trans('Change Password') }}</div>
        <div class="card-body p-4">
            <form action="{{ route('user.settings.password.update', $user->username) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Password') }}</label>
                        <input type="password" class="form-control form-control-md" name="current_password" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('New Password') }}</label>
                        <input type="password" class="form-control form-control-md" name="new_password" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Confirm New Password') }}</label>
                        <input type="password" class="form-control form-control-md" name="new_password_confirmation"
                            required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header fw-medium">{{ d_trans('2FA Authentication') }}</div>
        <div class="card-body p-4">
            <p class="text-muted">
                {{ d_trans('Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
            </p>
            <div class="my-3">
                <div class="row g-3 align-items-center">
                    @if ($user->isTwoFactorDisabled())
                        <div class="col-12 col-xl-auto">
                            <div class="text-center mb-2">
                                {!! $user->getTwoFactorQrCode() !!}
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="input-group mb-3">
                                <input id="input-link" type="text" class="form-control form-control-md "
                                    value="{{ $user->two_factor_secret }}" readonly>
                                <button class="btn btn-outline-primary btn-md btn-copy"
                                    data-clipboard-target="#input-link"><i class="far fa-clone"></i></button>
                            </div>
                            <button class="btn btn-primary btn-md w-100 " data-bs-toggle="modal"
                                data-bs-target="#towfactorModal">{{ d_trans('Enable 2FA Authentication') }}</button>
                        </div>
                    @else
                        <div class="col-12 col-xl-6">
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
    @if ($user->isTwoFactorDisabled())
        <div class="modal fade" id="towfactorModal" aria-labelledby="towfactorModalLabel" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title" id="createFolderModalLabel">{{ d_trans('OTP Code') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.settings.2fa.enable', $user->username) }}" method="POST">
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
                    <form action="{{ route('user.settings.2fa.disable', $user->username) }}" method="POST">
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
