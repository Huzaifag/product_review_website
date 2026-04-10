@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Themes'))
@section('header_title', d_trans(':theme_name Theme Settings', ['theme_name' => m_trans($theme->name)]))
@section('back', route('admin.settings.themes.index'))
@section('form', true)
@section('content')
    <div class="settings-box v2">
        <aside class="settings-side">
            @foreach ($themeSettingsGroups as $themeSettingsGroup)
                <a href="{{ route('admin.settings.themes.settings.group', [$theme->id, $themeSettingsGroup]) }}"
                    class="settings-link {{ $themeSettingsGroup == $activeGroup ? 'active' : '' }}">
                    <span class="capitalize">{{ d_trans(str_replace('_', ' ', $themeSettingsGroup)) }}</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @endforeach
        </aside>
        <div class="settings-content">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h5 class="settings-card-title capitalize">{{ d_trans(str_replace('_', ' ', $activeGroup)) }}</h5>
                </div>
                <div class="settings-card-body">
                    <form id="submittedForm"
                        action="{{ route('admin.settings.themes.settings.update', [$theme->id, $activeGroup]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3 mb-2">
                            @foreach ($themeSettingsCollection as $themeSetting)
                                @if ($themeSetting->field === 'input')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        @if (isset($themeSetting->disabled) && $themeSetting->disabled)
                                            <input type="{{ $themeSetting->type }}" class="form-control form-control-md"
                                                value="{{ $themeSetting->value }}" disabled>
                                        @else
                                            <input type="{{ $themeSetting->type }}" name="{{ $themeSetting->key }}"
                                                class="form-control" value="{{ $themeSetting->value }}"
                                                {{ $themeSetting->required ? 'required' : '' }}>
                                        @endif
                                    </div>
                                @elseif ($themeSetting->field === 'number')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        <input type="number" name="{{ $themeSetting->key }}"
                                            class="form-control form-control-md" value="{{ $themeSetting->value }}"
                                            min="{{ $themeSetting->min }}" max="{{ $themeSetting->max }}"
                                            {{ $themeSetting->required ? 'required' : '' }}>
                                    </div>
                                @elseif ($themeSetting->field === 'textarea')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        <textarea name="{{ $themeSetting->key }}" class="form-control form-control-md" rows="{{ $themeSetting->rows }}"
                                            {{ $themeSetting->required ? 'required' : '' }}>{{ $themeSetting->value }}</textarea>
                                    </div>
                                @elseif ($themeSetting->field === 'editor')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        <textarea name="{{ $themeSetting->key }}" class="editor">{{ $themeSetting->value }}</textarea>
                                    </div>
                                @elseif ($themeSetting->field === 'select')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        <select name="{{ $themeSetting->key }}" class="form-select form-select-md"
                                            {{ $themeSetting->required ? 'required' : '' }}>
                                            @foreach ($themeSetting->options as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $themeSetting->value == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif ($themeSetting->field === 'bootstrap-select')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        <select name="{{ $themeSetting->key }}" class="selectpicker selectpicker-md"
                                            title="{{ d_trans($themeSetting->label) }}"
                                            data-live-search="{{ $themeSetting->search }}"
                                            {{ $themeSetting->required ? 'required' : '' }}>
                                            @foreach ($themeSetting->options as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $themeSetting->value == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif ($themeSetting->field === 'checkbox')
                                    <div class="{{ $themeSetting->col }}">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="{{ $themeSetting->key }}"
                                                id="{{ $themeSetting->key }}"
                                                {{ $themeSetting->required ? 'required' : '' }}
                                                {{ $themeSetting->value ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ d_trans($themeSetting->label) }}
                                            </label>
                                        </div>
                                    </div>
                                @elseif ($themeSetting->field === 'radios')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        @foreach ($themeSetting->options as $key => $value)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="{{ $themeSetting->key }}" id="{{ $themeSetting->key . $key }}"
                                                    value="{{ $key }}"
                                                    {{ $themeSetting->value == $key ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $themeSetting->key . $key }}">
                                                    {{ $value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($themeSetting->field === 'toggle')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        <input type="checkbox" name="{{ $themeSetting->key }}"
                                            data-off="{{ d_trans($themeSetting->off) }}"
                                            data-on="{{ d_trans($themeSetting->on) }}" id="{{ $themeSetting->key }}"
                                            {{ $themeSetting->required ? 'required' : '' }} data-toggle="toggle"
                                            {{ $themeSetting->value ? 'checked' : '' }} data-height="45px">
                                    </div>
                                @elseif ($themeSetting->field === 'color')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ d_trans($themeSetting->label) }}</label>
                                        <div class="colorpicker">
                                            <input type="text" name="{{ $themeSetting->key }}"
                                                class="form-control form-control-md coloris"
                                                value="{{ $themeSetting->value }}"
                                                {{ $themeSetting->required ? 'required' : '' }}>
                                        </div>
                                    </div>
                                @elseif ($themeSetting->field === 'image')
                                    <div class="{{ $themeSetting->col }}">
                                        <x-admin.image-uploader version="v1" background="{{ $themeSetting->background }}"
                                            name="{{ $themeSetting->key }}" label="{{ d_trans($themeSetting->label) }}"
                                            src="{{ asset($themeSetting->value) }}"
                                            width="{{ $themeSetting->width ?? 'auto' }}"
                                            height="{{ $themeSetting->height ?? '60px' }}"
                                            accept="{{ $themeSetting->accept }}" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/coloris/coloris.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/coloris/coloris.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
    @endpush
@endsection
