@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Newsletter'))
@section('title', d_trans('Send Mail'))
@section('header_title', d_trans('Newsletter Send Mail'))
@section('back', route('admin.newsletter.subscribers.index'))
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.newsletter.subscribers.sendmail') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Subject') }} </label>
                        <input type="subject" name="subject" class="form-control form-control-md" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Reply to') }} </label>
                        <input type="email" name="reply_to" class="form-control form-control-md"
                            value="{{ authAdmin()->email }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Message') }} </label>
                        <textarea name="message" rows="10" class="editor"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-md px-5">{{ d_trans('Send') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
    @endpush
@endsection
