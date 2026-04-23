@extends('themes.basic.user.layout')
@section('title', d_trans(':username Profile', ['username' => ucfirst($user->getName())]))
@section('header_title', d_trans('My Plan'))
@section('breadcrumbs', Breadcrumbs::render('user.profile', $user))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'user.profile', $user))
@section('content')
    @if ($plan)
        @include('themes.basic.plans.usage', [
            'subscription' => $subscription,
            'plan' => $plan,
            'userProductViewCount' => $userProductViewCount,
            'productViewed' => $productViewed,
            'user' => $user,
        ])
    @else
        @include('themes.basic.partials.empty-box', [
            'empty_image' => 'v2',
            'title' => d_trans('No Active Plan'),
            'description' => d_trans(
                "You don't have an active plan yet. Upgrade your plan to access premium features."),
        ])
@endif
@endsection
