@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Themes'))
@section('header_title', d_trans(':theme_name Theme Custom CSS', ['theme_name' => m_trans($theme->name)]))
@section('back', route('admin.settings.themes.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.themes.custom-css.update', $theme->id) }}" method="POST">
        @csrf
        <textarea name="custom_css" id="css-editor">{{ $themeCustomCssFile }}</textarea>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/codemirror.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/monokai.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/codemirror/codemirror.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/css.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/sublime.min.js') }}"></script>
    @endpush
@endsection
