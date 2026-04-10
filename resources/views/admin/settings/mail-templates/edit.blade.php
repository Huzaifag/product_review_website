@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Mail Templates'))
@section('header_title', d_trans('Edit Mail Template'))
@section('back', route('admin.settings.mail-templates.group', $mailTemplate->group))
@section('form', true)
@section('content')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary border-0 text-white d-flex align-items-center">
                    <span class="badge bg-secondary me-2 capitalize">{{ d_trans($mailTemplate->group) }}</span>
                    <span>{{ d_trans($mailTemplate->name) }}</span>
                </div>
                <div class="card-body">
                    <form id="submittedForm" action="{{ route('admin.settings.mail-templates.update', $mailTemplate->id) }}"
                        method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="{{ $mailTemplate->isPermanent() ? 'col-lg-12' : 'col-lg-8' }}">
                                <label class="form-label">{{ d_trans('Subject') }} </label>
                                <input type="text" name="subject" class="form-control form-control-md"
                                    value="{{ $mailTemplate->subject }}" required>
                            </div>
                            @if (!$mailTemplate->isPermanent())
                                <div class="col-lg-4">
                                    <label class="form-label">{{ d_trans('Status') }} </label>
                                    <input type="checkbox" name="status" data-toggle="toggle" data-height="45px"
                                        @checked($mailTemplate->isActive())>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Body') }} </label>
                            <textarea name="body" class="editor">{{ $mailTemplate->body }}</textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-primary border-0 text-white">
                    {{ d_trans('Short Codes') }}
                </div>
                <div class="card-body">
                    @foreach ($mailTemplate->shortcodes as $shortcode)
                        <div class="input-group {{ !$loop->last ? 'mb-3' : '' }}">
                            <input id="{{ $shortcode }}" type="text" class="form-control form-control-md"
                                value="@php echo str("{{ ". $shortcode ." }}")->replace(' ', '') @endphp" readonly>
                            <button class="btn btn-soft px-3 btn-copy" type="button"
                                data-clipboard-target="#{{ $shortcode }}"><i class="far fa-clone"></i></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
    @endpush
@endsection
