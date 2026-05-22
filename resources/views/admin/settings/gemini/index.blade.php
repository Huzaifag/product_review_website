@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Settings'))
@section('title', d_trans('Gemini'))
@section('header_title', d_trans('Gemini Settings'))
@section('back', route('admin.settings.index'))
@section('form', true)
@section('content')
    <div class="card">
        <form id="submittedForm" action="{{ route('admin.settings.gemini.update') }}" method="POST">
            @csrf
            <div class="card-header">{{ d_trans('Gemini Configuration') }}</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('API Key') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="gemini[api_key]" class="remove-spaces form-control form-control-md"
                                value="{{ demo(config('settings.gemini.api_key')) }}"
                                placeholder="{{ d_trans('Enter Gemini API key') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Model') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="gemini[model]" class="remove-spaces form-control form-control-md"
                                value="{{ config('settings.gemini.model') }}" placeholder="{{ d_trans('e.g. gemini-pro') }}">
                        </div>
                    </div>
                </li>
            </ul>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ d_trans('Save Changes') }}</button>
            </div>
        </form>
    </div>
@endsection
