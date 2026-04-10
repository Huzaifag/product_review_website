@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Pricing plans'))
@section('title', d_trans('Edit plan'))
@section('header_title', d_trans('Edit plan'))
@section('back', route('admin.plans.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-4">
            <div class="card-header">{{ d_trans('Actions') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Status') }}</label>
                        <input type="checkbox" name="status" data-toggle="toggle" data-height="40px"
                            @checked($plan->isActive())>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Featured') }}</label>
                        <input type="checkbox" name="featured" data-toggle="toggle" data-height="40px"
                            data-on="{{ d_trans('Yes') }}" data-off="{{ d_trans('No') }}" @checked($plan->isFeatured())>
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
                            value="{{ $plan->name }}" autofocus required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Interval') }}</label>
                        <select class="form-select form-select-md" disabled>
                            <option value="" selected>{{ $plan->getIntervalName() }}</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <x-input-price label="{{ d_trans('Price') }}" name="price" value="{{ price($plan->price) }}"
                                size="md" :required=true />
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Total Businesses') }}</label>
                        <input type="number" name="businesses" class="form-control form-control-md" placeholder="0"
                            value="{{ $plan->businesses }}">
                        <div class="form-text">{{ d_trans('Leave the field empty for unlimited businesses.') }}</div>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Employees') }}</label>
                        <input type="checkbox" name="employees" data-toggle="toggle" data-height="40px"
                            data-on="{{ d_trans('Enabled') }}" @checked($plan->hasEmployeesFeature())>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Categories') }}</label>
                        <input type="checkbox" name="categories" data-toggle="toggle" data-height="40px"
                            data-on="{{ d_trans('Enabled') }}" @checked($plan->hasCategoriesFeature())>
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
                    @if ($plan->custom_features)
                        @foreach ($plan->custom_features as $key => $customFeature)
                            <div class="col-12 custom-feature-box-{{ $key }}">
                                <div class="input-group">
                                    <input type="text" name="custom_features[]" class="form-control form-control-md"
                                        value="{{ $customFeature }}" required>
                                    <button class="btn btn-danger btn-md custom-feature-remove" type="button"
                                        data-id="{{ $key }}">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let customFeaturesTotal = {{ $plan->custom_features ? count($plan->custom_features) : 1 }};
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
