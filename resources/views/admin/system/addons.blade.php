@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('System'))
@section('title', d_trans('Addons'))
@section('header_title', d_trans('Addons'))
@section('back', route('admin.system.index'))
@section('upload', true)
@section('content')
    <div class="card">
        @forelse($addons as $addon)
            <div class="addon">
                <div class="addon-img">
                    @if ($addon->action)
                        <a href="{{ adminUrl($addon->action) }}">
                            <img src="{{ asset($addon->thumbnail) }}" alt="{{ $addon->name }}">
                        </a>
                    @else
                        <img src="{{ asset($addon->thumbnail) }}" alt="{{ $addon->name }}">
                    @endif
                </div>
                <div class="addon-info">
                    <div>
                        @if ($addon->action)
                            <a href="{{ adminUrl($addon->action) }}">
                                <h6 class="addon-title">{{ $addon->name }}</h6>
                            </a>
                        @else
                            <h6 class="addon-title">{{ $addon->name }}</h6>
                        @endif
                        <p class="addon-version">
                            {{ d_trans('Version: :version', ['version' => $addon->version]) }}
                        </p>
                    </div>
                    <div class="addon-actions">
                        @if (!$addon->hasNoStatus())
                            <div class="form-check form-switch form-switch-lg">
                                <input class="form-check-input addon-status" type="checkbox" id="status" name="status"
                                    data-update-link="{{ route('admin.system.addons.update', $addon->id) }}"
                                    @checked($addon->isActive())>
                            </div>
                        @endif
                        @if ($addon->action)
                            <a href="{{ adminUrl($addon->action) }}" class="btn btn-soft">
                                <i class="bi bi-gear me-1"></i><span>{{ d_trans('Settings') }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="settings-card-body col-lg-8 m-auto">
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            </div>
        @endforelse
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <h5 class="modal-header bg-primary text-white mb-0">{{ d_trans('Addon Upload') }}</h5>
                <div class="modal-body p-4">
                    <div class="note note-warning mb-3">
                        <h6 class="mb-2"><strong>{{ d_trans('Important!') }}</strong></h6>
                        <ul class="mb-0">
                            <li class="mb-1">
                                {{ d_trans('Make sure you are uploading the correct files.') }}
                            </li>
                            <li class="mb-0">
                                {{ d_trans('Before uploading a new addon make sure to take a backup of your website files and database.') }}
                            </li>
                        </ul>
                    </div>
                    <form action="{{ route('admin.system.addons.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Addon Purchase Code') }} </label>
                            <input type="text" name="purchase_code" class="form-control form-control-md"
                                placeholder="{{ d_trans('Purchase code') }}" value="{{ old('purchase_code') }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ d_trans('Addon Files (Zip)') }} </label>
                            <input type="file" name="addon_files" class="form-control form-control-md" accept=".zip"
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
