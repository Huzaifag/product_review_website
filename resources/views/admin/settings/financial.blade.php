@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Settings'))
@section('title', d_trans('Financial'))
@section('header_title', d_trans('Financial Settings'))
@section('back', route('admin.settings.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.financial.update') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Currency') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Currency Code') }}</label>
                                <input type="text" name="currency[code]" class="form-control form-control-md"
                                    value="{{ config('settings.currency.code') }}" placeholder="{{ d_trans('USD') }}"
                                    required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Currency Symbol') }}</label>
                                <input type="text" name="currency[symbol]" class="form-control form-control-md"
                                    value="{{ config('settings.currency.symbol') }}" placeholder="$" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Currency position') }}</label>
                                <select name="currency[position]" class="form-select form-select-md">
                                    @foreach (\App\Models\Setting::getAvailableCurrencyPositions() as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == config('settings.currency.position') ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
