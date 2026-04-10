@extends('themes.basic.layouts.single')
@section('title', $page->title)
@section('header_title', $page->title)
@section('description', $page->description)
@section('keywords', $page->keywords)
@section('breadcrumbs', Breadcrumbs::render('page', $page))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'page', $page))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')
    <div class="box">
        {!! $page->body !!}
    </div>
@endsection
