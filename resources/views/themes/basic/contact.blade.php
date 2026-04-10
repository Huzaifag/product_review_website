@extends('themes.basic.layouts.single')
@section('title', d_trans('Contact US'))
@section('header_title', d_trans('Contact US'))
@section('breadcrumbs', Breadcrumbs::render('contact'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'contact'))
@section('header_v1', true)
@section('container', 'container-custom')
@section('content')
    <div class="box">
        <form action="{{ route('contact') }}" method="POST">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-12 col-lg-6">
                    <label class="form-label">{{ d_trans('Name') }}</label>
                    <input type="text" name="name" class="form-control form-control-md"
                        value="{{ authUser() ? authUser()->getName() : '' }}" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">{{ d_trans('Email') }}</label>
                    <input type="email" name="email" class="form-control form-control-md"
                        value="{{ authUser() ? authUser()->email : '' }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">{{ d_trans('Subject') }}</label>
                    <input type="text" name="subject" class="form-control form-control-md" value="{{ old('subject') }}"
                        required>
                </div>
                <div class="col-12">
                    <label class="form-label">{{ d_trans('Message') }}</label>
                    <textarea class="form-control" name="message" rows="8" required>{{ old('message') }}</textarea>
                </div>
            </div>
            <x-captcha />
            <button class="btn btn-primary btn-md px-5">{{ d_trans('Send') }}</button>
        </form>
    </div>
@endsection
