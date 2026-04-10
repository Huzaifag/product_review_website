@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Admins'))
@section('header_title', d_trans('Edit Admin :name', ['name' => $admin->getName()]))
@section('back', route('admin.members.admins.index'))
@section('content')
    <div class="settings-box v2">
        @include('admin.members.admins.includes.sidebar')
        <div class="settings-content">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h5 class="settings-card-title">{{ d_trans('Account Details') }}</h5>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('admin.members.admins.update', $admin->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="attach-img">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <img src="{{ $admin->getAvatar() }}" alt="{{ $admin->getName() }}"
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
                                    value="{{ $admin->firstname }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Last Name') }} </label>
                                <input type="lastname" name="lastname" class="form-control form-control-md"
                                    value="{{ $admin->lastname }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Username') }} </label>
                                <input type="text" name="username" class="form-control form-control-md"
                                    value="{{ $admin->username }}" minlength="3" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Email Address') }} </label>
                                <input type="email" name="email" class="form-control form-control-md"
                                    value="{{ demo($admin->email) }}" required>
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
