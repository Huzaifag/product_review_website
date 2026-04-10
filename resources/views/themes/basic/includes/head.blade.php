@php
    $title = seoTitle($__env);
    $description = $__env->yieldContent('description')
        ? $__env->yieldContent('description')
        : m_trans(config('settings.seo.description')) ?? '';
    $keywords = $__env->yieldContent('keywords')
        ? $__env->yieldContent('keywords')
        : m_trans(config('settings.seo.keywords')) ?? '';
    $ogImage = $__env->yieldContent('og_image')
        ? $__env->yieldContent('og_image')
        : asset(config('theme.settings.general.social_image'));
@endphp
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="{{ config('theme.settings.colors.primary_color') }}">
@hasSection('no_index')
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="no index">
@endif
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta property="og:site_name" content="{{ m_trans(m_trans(config('settings.general.site_name'))) }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{!! $title !!}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image:height" content="600">
<meta property="og:image:width" content="316">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{!! $title !!}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image:src" content="{{ $ogImage }}">
<title>{!! $title !!}</title>
<link rel="canonical" href="{{ url()->current() }}" />
<link rel="icon" href="{{ asset(config('theme.settings.general.favicon')) }}">
@include('themes.basic.includes.styles')
{!! schema($__env) !!}
@yield('breadcrumbs_schema')
@stack('schema')
