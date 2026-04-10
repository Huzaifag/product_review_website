@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Languages'))
@section('header_title', d_trans(':language translates', ['language' => $language->name]))
@section('back', route('admin.settings.languages.index'))
@section('form', true)
@section('content')
    <div class="note note-warning mb-3">
        <div class="d-flex gap-3">
            <div class="note-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="text-dark">
                <div class="mb-1">
                    <strong>{{ d_trans('Important!') }}</strong>
                </div>
                <li class="fw-light">
                    {!! d_trans(
                        'There are some words that should not be translated that start with some tags or are inside a tag like :tags etc...',
                        [
                            'tags' => '<strong>:value, :seconds, :min, ::max, {username}</strong>',
                        ],
                    ) !!}
                </li>
                <li class="fw-light">{{ d_trans('You must clear the cache after saving the translations.') }}</li>
                <li class="fw-light">{{ d_trans('Dynamic translates are automatically added and they cannot be deleted.') }}
                </li>
                <li class="fw-light">
                    {{ d_trans('Manual translates are are the new content you added and they can be deleted.') }}
                </li>
            </div>
        </div>
    </div>
    <div class="dashboard-tabs">
        <a href="{{ route('admin.settings.languages.translates', $language->id) }}"
            class="dashboard-tabs-item {{ $type == \App\Models\Translate::TYPE_DYNAMIC ? 'current' : '' }}">
            <i class="bi bi-translate"></i>
            <span class="ms-1">{{ d_trans('Dynamic Translates') }}</span>
        </a>
        <a href="{{ route('admin.settings.languages.translates.type', [$language->id, \App\Models\Translate::TYPE_MANUAL]) }}"
            class="dashboard-tabs-item {{ $type == \App\Models\Translate::TYPE_MANUAL ? 'current' : '' }}">
            <i class="bi bi-translate"></i>
            <span class="ms-1">{{ d_trans('Manual Translates') }}</span>
        </a>
    </div>
    <div class="translates">
        <div class="mt-3">
            <div class="card">
                <div class="card-header border-bottom">
                    @if ($type == \App\Models\Translate::TYPE_MANUAL)
                        <button class="btn btn-outline-primary btn-md mb-3" data-bs-toggle="modal"
                            data-bs-target="#translateModal"><i
                                class="fa fa-plus me-2"></i>{{ d_trans('Add New') }}</button>
                    @endif
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-3">
                            <div class="col-lg-10">
                                <input type="text" name="search" class="form-control form-control-md"
                                    placeholder="{{ d_trans('Search...') }}" value="{{ request('search') }}">
                            </div>
                            <div class="col">
                                <button class="btn btn-primary btn-md w-100"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="col">
                                <a href="{{ url()->current() }}"
                                    class="btn btn-soft btn-md w-100">{{ d_trans('Reset') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <form id="submittedForm"
                        action="{{ route('admin.settings.languages.translates.update', $language->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-cols-1 g-3">
                            @forelse ($translates as $translate)
                                <div class="col">
                                    <div class="d-flex align-items-center flex-column flex-md-row gap-3 gap-md-4">
                                        <textarea type="text" class="form-control form-control-md translate-key " rows="1" auto-size readonly>{{ $translate->key }}</textarea>
                                        <div class="translate-arrow text-primary">
                                            <i class="fa-solid fa-angles-right d-none d-md-block"></i>
                                            <i class="fa-solid fa-angles-down d-md-none"></i>
                                        </div>
                                        <textarea type="text" name="translates[{{ $translate->id }}]" class="form-control form-control-md auto-size"
                                            rows="1" auto-size>{{ $translate->value }}</textarea>
                                        @if ($translate->isManual())
                                            <button type="button" class="btn btn-outline-danger btn-md"
                                                onclick="submitDeleteForm(event, {{ $translate->id }})">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col">
                                    <div class="text-center text-muted p-5">
                                        <span>{{ d_trans('No data found') }}</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{ $translates->links() }}
    </div>
    <div class="modal fade" id="translateModal" tabindex="-1" aria-labelledby="translateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ d_trans('Add New') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.settings.languages.translates.store', $language->id) }}" method="POST">
                        @csrf
                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Key') }}</label>
                                <textarea type="text" name="key" class="form-control form-control-md" rows="1" auto-size>{{ old('key') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Value') }}</label>
                                <textarea type="text" name="value" class="form-control form-control-md" rows="1" auto-size>{{ old('value') }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md w-100">{{ d_trans('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form id="deleteForm" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/autosize/autosize.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            "use strict";

            function submitDeleteForm(event, translateId) {
                event.preventDefault();
                const confirmDelete = confirm("{{ d_trans('Are you sure you want to delete this translation?') }}");
                if (confirmDelete) {
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action =
                        `{{ route('admin.settings.languages.translates.destroy', [$language->id, '']) }}/${translateId}`;
                    deleteForm.submit();
                }
            }
        </script>
    @endpush
@endsection
