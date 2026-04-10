@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Subscriptions'))
@section('title', d_trans('New subscription'))
@section('header_title', d_trans('New subscription'))
@section('back', route('admin.subscriptions.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.subscriptions.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Business Owner') }}</label>
                        <select name="owner" class="selectpicker selectpicker-md" title="{{ d_trans('Choose') }}"
                            data-live-search="true">
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}" @selected(old('owner') == $owner->id)>
                                    {{ $owner->getName() }} ({{ $owner->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Plan') }}</label>
                        <select name="plan" class="selectpicker selectpicker-md" title="{{ d_trans('Choose') }}"
                            data-live-search="true">
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @selected(old('plan') == $plan->id)>
                                    {{ $plan->trans->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
