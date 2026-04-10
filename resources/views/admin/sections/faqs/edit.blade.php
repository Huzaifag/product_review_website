@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Sections'))
@section('title', d_trans('FAQs'))
@section('header_title', d_trans('Edit FAQ'))
@section('back', route('admin.sections.faqs.index'))
@section('form', true)
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.sections.faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Title') }}</label>
                        <input type="text" name="title" class="form-control form-control-md" value="{{ $faq->title }}"
                            required />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Body') }}</label>
                        <textarea name="body" class="editor">{{ $faq->body }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
    @endpush
@endsection
