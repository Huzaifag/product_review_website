@extends('themes.basic.businesses.layout')
@section('no_index', true)
@section('title', d_trans(':business_name Review', ['business_name' => ucFirst($business->trans->name)]))
@section('breadcrumbs', Breadcrumbs::render('businesses.review.show', $review))
@section('container', 'container-custom-xs')
@section('content')
    @include('themes.basic.partials.review', [
        'review' => $review,
        'review_referrer' => $business->getLink(),
    ])
@endsection
