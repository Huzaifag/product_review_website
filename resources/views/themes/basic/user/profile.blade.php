@extends('themes.basic.user.layout')
@section('title', d_trans(':username Profile', ['username' => ucfirst($user->getName())]))
@section('header_title', d_trans('Reviews'))
@section('breadcrumbs', Breadcrumbs::render('user.profile', $user))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'user.profile', $user))
@section('content')
    @if ($reviews->count() > 0)
        <div class="item-reviews gap-4">
            @foreach ($reviews as $review)
                @include('themes.basic.partials.review', [
                    'review_header' => true,
                    'review' => $review,
                    'review_referrer' => $user->getProfileLink(),
                ])
            @endforeach
        </div>
        {{ $reviews->links() }}
    @else
        @include('themes.basic.partials.empty-box', [
            'empty_image' => 'v2',
            'title' => d_trans('No Reviews Found'),
            'description' => d_trans(
                "This user hasn't reviewed any businesses yet. Their reviews will appear here once submitted"),
        ])
    @endif
@endsection
