@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Pricing plans'))
@section('title', d_trans('New plan'))
@section('header_title', d_trans('New plan'))
@section('back', route('admin.plans.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.plans.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header">{{ d_trans('Actions') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Status') }}</label>
                        <input type="checkbox" name="status" data-toggle="toggle" data-height="40px"
                            @checked(old('status') ?? true)>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Featured') }}</label>
                        <input type="checkbox" name="featured" data-toggle="toggle" data-height="40px"
                            data-on="{{ d_trans('Yes') }}" data-off="{{ d_trans('No') }}" @checked(old('featured'))>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">{{ d_trans('Plan Details') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" autofocus required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Interval') }}</label>
                        <select name="interval" class="form-select form-select-md">
                            @foreach ($intervals as $intervalKey => $intervalValue)
                                <option value="{{ $intervalKey }}" @selected(old('interval') == $intervalKey)>{{ $intervalValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <x-input-price label="{{ d_trans('Price') }}" name="price" size="md" :required=true />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Total Businesses') }}</label>
                        <input type="number" name="businesses" class="form-control form-control-md" placeholder="0"
                            value="{{ old('businesses') }}">
                        <div class="form-text">{{ d_trans('Leave the field empty for unlimited businesses.') }}</div>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Employees') }}</label>
                        <input type="checkbox" name="employees" data-toggle="toggle" data-height="40px"
                            data-on="{{ d_trans('Enabled') }}" @checked(old('employees'))>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Categories') }}</label>
                        <input type="checkbox" name="categories" data-toggle="toggle" data-height="40px"
                            data-on="{{ d_trans('Enabled') }}" @checked(old('categories'))>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ d_trans('Custom Features') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 custom-features">
                    <div class="col-12">
                        <button id="addCustomFeature" type="button" class="btn btn-dark btn-md">
                            <i class="fa fa-plus me-1"></i>
                            {{ d_trans('Add custom feature') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let customFeaturesTotal = 1;
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/jquery/jquery.priceformat.min.js') }}"></script>
    @endpush
@endsection
