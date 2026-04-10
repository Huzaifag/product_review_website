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
                <h5 class="settings-content-title">{{ d_trans('Account details') }}</h5>
            </div>
            <div class="settings-content-body">
                <form action="{{ route('business.account.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-cols-1 g-4">
                        <div class="col">
                            <div class="row align-items-center g-3 attach-img">
                                <div class="col-auto">
                                    <div class="settings-user-img">
                                        <img src="{{ $businessOwner->getAvatar() }}" alt="{{ $businessOwner->getName() }}"
                                            class="attach-img-preview">
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-light attach-img-button">
                                        <i class="fa fa-camera me-2"></i>{{ d_trans('Choose Avatar') }}
                                    </button>
                                    <input type="file" name="avatar" class="attach-img-input"
                                        accept="image/png, image/jpg, image/jpeg" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label">{{ d_trans('First Name') }}</label>
                                    <input type="text" name="firstname" class="form-control form-control-md"
                                        value="{{ $businessOwner->firstname }}" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label">{{ d_trans('Last Name') }}</label>
                                    <input type="text" name="lastname" class="form-control form-control-md"
                                        value="{{ $businessOwner->lastname }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ d_trans('Username') }}</label>
                                    <input type="text" name="username" class="form-control form-control-md"
                                        value="{{ $businessOwner->username }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ d_trans('Email') }}</label>
                                    <input type="text" name="email" class="form-control form-control-md"
                                        value="{{ $businessOwner->email }}" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label">{{ d_trans('Address line 1') }}</label>
                                    <input type="text" name="address_line_1" class="form-control form-control-md"
                                        value="{{ @$businessOwner->address->line_1 }}" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label">{{ d_trans('Address line 2') }}</label>
                                    <input type="text" name="address_line_2" class="form-control form-control-md"
                                        value="{{ @$businessOwner->address->line_2 }}">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">{{ d_trans('City') }}</label>
                                    <input type="text" name="city" class="form-control form-control-md"
                                        value="{{ @$businessOwner->address->city }}" required>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">{{ d_trans('State') }}</label>
                                    <input type="text" name="state" class="form-control form-control-md"
                                        value="{{ @$businessOwner->address->state }}" required>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">{{ d_trans('Postal code') }}</label>
                                    <input type="text" name="zip" class="form-control form-control-md"
                                        value="{{ @$businessOwner->address->zip }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ d_trans('Country') }}</label>
                                    <select name="country" class="form-select form-select-md" required>
                                        <option value="">--</option>
                                        @foreach (countries() as $countryCode => $countryName)
                                            <option value="{{ $countryCode }}" @selected(@$businessOwner->address->country == $countryCode)>
                                                {{ $countryName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
