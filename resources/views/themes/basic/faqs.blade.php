@extends('themes.basic.layouts.single')
@section('title', d_trans('Frequently Asked Questions'))
@section('header_title', d_trans('FAQs'))
@section('breadcrumbs', Breadcrumbs::render('faqs'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'faqs'))
@section('header_v1', true)
@section('container', 'container-custom-xs')
@section('content')
    <div class="accordion accordion-custom" id="accordion">
        <div class="row row-cols-1  g-3">
            @foreach ($faqs as $faq)
                <div class="col">
                    @include('themes.basic.partials.faq-accordion', ['faq' => $faq])
                </div>
            @endforeach
        </div>
    </div>
    {{ $faqs->links() }}
@endsection
