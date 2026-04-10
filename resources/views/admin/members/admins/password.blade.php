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
                    <h5 class="settings-card-title">{{ d_trans('Change Password') }}</h5>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('admin.members.admins.password.update', $admin->id) }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('New Password') }} </label>
                                <input type="password" class="form-control  form-control-md" name="new_password" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Confirm New Password') }} </label>
                                <input type="password" class="form-control  form-control-md"
                                    name="new_password_confirmation" required>
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
