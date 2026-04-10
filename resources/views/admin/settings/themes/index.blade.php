@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Themes'))
@section('header_title', d_trans('Themes'))
@section('back', route('admin.settings.index'))
@section('upload', true)
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3">
        @foreach ($themes as $theme)
            <div class="col">
                <div class="card theme-card">
                    <div class="card-header p-0 border-bottom">
                        @if ($theme->isActive())
                            <span class="badge bg-success theme-card-active-badge shadow-sm">{{ d_trans('Active') }}</span>
                        @endif
                        <img src="{{ $theme->getPreviewImageLink() }}" class="card-img-top theme-card-image" />
                    </div>
                    <div class="card-body">
                        <h5 class="card-title theme-card-title">
                            {{ m_trans($theme->name) }}
                            @if ($theme->version)
                                <span>{{ d_trans('v:version', ['version' => $theme->version]) }}</span>
                            @endif
                        </h5>
                        <p class="card-text theme-card-text">{{ d_trans($theme->description) }}</p>
                        <div class="row g-2">
                            <div class="col">
                                <form action="{{ route('admin.settings.themes.active', $theme->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="btn btn-primary btn-md w-100 action-confirm {{ $theme->isActive() ? 'disabled' : '' }}"><i
                                            class="fa-solid fa-check-double me-2"></i>{{ d_trans('Make Active') }}</button>
                                </form>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-md btn-soft" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v fa-sm"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                        aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a href="{{ route('admin.settings.themes.settings.index', $theme->id) }}"
                                                class="dropdown-item">
                                                <i class="bi bi-gear"></i>{{ d_trans('Settings') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.settings.themes.custom-css.index', $theme->id) }}">
                                                <i class="bi bi-code-slash"></i>{{ d_trans('Custom CSS') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <h5 class="modal-header bg-primary text-white mb-0">{{ d_trans('Theme Upload') }}</h5>
                <div class="modal-body p-4">
                    <div class="note note-warning mb-3">
                        <h6 class="mb-2"><strong>{{ d_trans('Important!') }}</strong></h6>
                        <ul class="mb-0">
                            <li class="mb-1">
                                {{ d_trans('Make sure you are uploading the correct files.') }}
                            </li>
                            <li class="mb-0">
                                {{ d_trans('Before uploading a new theme make sure to take a backup of your website files and database.') }}
                            </li>
                        </ul>
                    </div>
                    <form action="{{ route('admin.settings.themes.upload') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Theme Purchase Code') }} </label>
                            <input type="text" name="purchase_code" class="form-control form-control-md"
                                placeholder="{{ d_trans('Purchase code') }}" value="{{ old('purchase_code') }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ d_trans('Theme Files (Zip)') }} </label>
                            <input type="file" name="theme_files" class="form-control form-control-md" accept=".zip"
                                required>
                        </div>
                        <div class="row justify-content-center g-3">
                            <div class="col-12 col-lg">
                                <button type="button" class="btn btn-outline-primary btn-md w-100" data-bs-dismiss="modal"
                                    aria-label="Close">{{ d_trans('Close') }}</button>
                            </div>
                            <div class="col-12 col-lg">
                                <button class="btn btn-primary btn-md w-100">{{ d_trans('Upload') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
