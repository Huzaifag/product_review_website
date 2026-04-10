@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Settings'))
@section('title', d_trans('Taxes'))
@section('header_title', d_trans('Edit Tax'))
@section('back', route('admin.settings.taxes.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.taxes.update', $tax->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card p-2">
            <div class="card-body">
                <div class="row g-3 row-cols-1 mb-2">
                    <div class="col">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-md" value="{{ $tax->name }}"
                            required autofocus />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ d_trans('Rate') }} </label>
                        <div class="input-group input-group-md">
                            <input type="number" name="rate" class="form-control form-control-md"
                                value="{{ $tax->rate }}" placeholder="0" min="1" max="100" required />
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ d_trans('Countries') }}</label>
                        <select name="countries[]" class="selectpicker selectpicker-md" multiple data-live-search="true"
                            title="--" required>
                            @foreach (countries() as $countryCode => $countryName)
                                <option value="{{ $countryCode }}" @selected(in_array($countryCode, $tax->countries))>
                                    {{ $countryName }}
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
