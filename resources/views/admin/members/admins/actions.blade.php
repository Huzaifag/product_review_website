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
                    <h5 class="settings-card-title">{{ d_trans('Actions') }}</h5>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('admin.members.admins.actions.update', $admin->id) }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">{{ d_trans('Two-Factor Authentication') }} </label>
                                        <input id="2faCheckbox" type="checkbox" name="two_factor_status"
                                            data-toggle="toggle" @checked($admin->isTwoFactorActive())>
                                    </div>
                                </div>
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
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
    @endpush
@endsection
