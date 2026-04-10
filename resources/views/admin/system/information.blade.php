@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('System'))
@section('title', d_trans('Information'))
@section('header_title', d_trans('System Information'))
@section('back', route('admin.system.index'))
@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white border-bottom-0"><i
                class="fas fa-folder me-2"></i>{{ d_trans('Application') }}</div>
        <ul class="list-group custom list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 fs-6">
                <strong>{{ d_trans('Name') }}</strong>
                <span class="capitalize">{{ str_replace('_', ' ', ucfirst(config('system.item.alias'))) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light py-3 fs-6">
                <strong>{{ d_trans('Version') }}</strong>
                <span>{{ d_trans('v:version', ['version' => config('system.item.version')]) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 fs-6">
                <strong>{{ d_trans('Laravel Version') }}</strong>
                <span>{{ d_trans('v:version', ['version' => app()->version()]) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light py-3 fs-6">
                <strong>{{ d_trans('Timezone') }}</strong>
                <span class="capitalize">{{ config('app.timezone') }}</span>
            </li>
        </ul>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-dark text-white border-bottom-0"><i
                class="fas fa-server me-2"></i>{{ d_trans('Server Details') }}</div>
        <ul class="custom-list-group system list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 fs-6">
                <strong>{{ d_trans('Software') }}</strong>
                <span>{{ $_SERVER['SERVER_SOFTWARE'] }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light py-3 fs-6">
                <strong>{{ d_trans('PHP Version') }}</strong>
                <span>v{{ phpversion() }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 fs-6">
                <strong>{{ d_trans('IP Address') }}</strong>
                <span>{{ $_SERVER['SERVER_ADDR'] }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light py-3 fs-6">
                <strong>{{ d_trans('Protocol') }}</strong>
                <span>{{ $_SERVER['SERVER_PROTOCOL'] }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 fs-6">
                <strong>{{ d_trans('HTTP Host') }}</strong>
                <span>{{ $_SERVER['HTTP_HOST'] }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light py-3 fs-6">
                <strong>{{ d_trans('Port') }}</strong>
                <span>{{ $_SERVER['SERVER_PORT'] }}</span>
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-header bg-c-1 text-white border-bottom-0"><i
                class="fas fa-database me-2"></i>{{ d_trans('System Cache') }}</div>
        <ul class="custom-list-group system list-group list-group-flush">
            <li class="list-group-item py-3 fs-6">
                <i class="far fa-check-circle me-2 text-danger"></i>
                <span>{{ d_trans('Compiled views will be cleared') }}</span>
            </li>
            <li class="list-group-item py-3 fs-6">
                <i class="far fa-check-circle me-2 text-danger"></i>
                <span>{{ d_trans('Application cache will be cleared') }}</span>
            </li>
            <li class="list-group-item py-3 fs-6">
                <i class="far fa-check-circle me-2 text-danger"></i>
                <span>{{ d_trans('Route cache will be cleared') }}</span>
            </li>
            <li class="list-group-item py-3 fs-6">
                <i class="far fa-check-circle me-2 text-danger"></i>
                <span>{{ d_trans('Configuration cache will be cleared') }}</span>
            </li>
            <li class="list-group-item py-3 fs-6">
                <i class="far fa-check-circle me-2 text-danger"></i>
                <span>{{ d_trans('All Other Caches will be cleared') }}</span>
            </li>
            <li class="list-group-item py-3 fs-6">
                <i class="far fa-check-circle me-2 text-danger"></i>
                <span>{{ d_trans('Error logs file will be cleared') }}</span>
            </li>
            <li class="list-group-item p-0"></li>
        </ul>
        <div class="card-body">
            <a href="{{ route('admin.system.information.cache') }}" class="btn btn-danger btn-md w-100 action-confirm">
                <i class="fa-solid fa-broom icon-rtl me-2"></i>{{ d_trans('Clear Cache') }}
            </a>
        </div>
    </div>
@endsection
