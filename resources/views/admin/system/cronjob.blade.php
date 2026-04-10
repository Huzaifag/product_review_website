@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('System'))
@section('title', d_trans('Cron Job'))
@section('header_title', d_trans('System Cron Job'))
@section('back', route('admin.system.index'))
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row g-2">
                <div class="col-12 col-lg">
                    <h5 class="mb-0">{{ d_trans('Command') }}</h5>
                </div>
                @if (config('settings.cronjob.last_execution'))
                    <div class="col-12 col-lg-auto">
                        <i class="small fw-light">
                            {{ d_trans('Last Execution: :date', ['date' => dateFormat(config('settings.cronjob.last_execution'))]) }}
                        </i>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <div class="input-group">
                    <input id="cronInput" type="text" class="form-control form-control-md"
                        value="wget -q -O /dev/null {{ config('settings.cronjob.key') ? route('cronjob', ['key' => config('settings.cronjob.key')]) : route('cronjob') }}"
                        readonly>
                    <button class="btn btn-soft px-3 btn-copy" type="button" data-clipboard-target="#cronInput"><i
                            class="far fa-clone"></i></button>
                </div>
                <div class="input-text mt-2">
                    {{ d_trans('The cron job command must be set to run every minute') }} ( <code>* * * * *</code>
                    ).
                </div>
            </div>
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-auto">
                    <form action="{{ route('admin.system.cronjob.key-generate') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-primary btn-md w-100 action-confirm">
                            <i class="fa-solid fa-rotate me-2"></i>
                            {{ d_trans('Generate Key') }}</button>
                    </form>
                </div>
                <div class="col-12 col-lg-auto">
                    <form action="{{ route('admin.system.cronjob.key-remove') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-md w-100 action-confirm" @disabled(!config('settings.cronjob.key'))>
                            <i class="fa-regular fa-trash-can me-2"></i>
                            {{ d_trans('Remove Key') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
