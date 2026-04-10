@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Users'))
@section('header_title', d_trans('Edit User :name', ['name' => $user->getName()]))
@section('back', route('admin.members.users.index'))
@section('content')
    @include('admin.members.users.includes.widgets')
    <div class="settings-box v2">
        @include('admin.members.users.includes.sidebar')
        <div class="settings-content">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h5 class="settings-card-title">{{ d_trans('Account Details') }}</h5>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('admin.members.users.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="attach-img">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}"
                                                class="attach-img-preview rounded-3 border" width="80px" height="80px">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-soft attach-img-button"><i
                                                    class="fas fa-camera me-2"></i>{{ d_trans('Choose Image') }}</button>
                                            <input type="file" name="avatar" class="attach-img-input"
                                                accept="image/png, image/jpg, image/jpeg" hidden="">
                                        </div>
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
        </div>
    </div>
@endsection
