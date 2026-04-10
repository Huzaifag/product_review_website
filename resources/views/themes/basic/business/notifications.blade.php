@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-lg')
@section('title', d_trans('Notifications'))
@section('header_title', d_trans('Notifications'))
@section('breadcrumbs', Breadcrumbs::render('business.notifications'))
@section('content')
    @if ($notifications->count() > 0)
        <div class="noti noti-lg">
            <div class="noti-body">
                <div class="d-flex flex-column">
                    @foreach ($notifications as $notification)
                        @if ($notification->link)
                            <a href="{{ route('business.notifications.view', $notification->id) }}"
                                class="noti-item {{ !$notification->status ? 'unread' : '' }}">
                                <div class="noti-item-img">
                                    <img src="{{ $notification->image }}" alt="{{ $notification->title }}">
                                </div>
                                <div class="noti-item-info">
                                    <p class="noti-item-text mb-0">{{ $notification->title }}</p>
                                    <span class="noti-item-time">{{ $notification->created_at->diffforhumans() }}</span>
                                </div>
                            </a>
                        @else
                            <div class="noti-item {{ !$notification->status ? 'unread' : '' }}">
                                <div class="noti-item-img">
                                    <img src="{{ $notification->image }}" alt="{{ $notification->title }}">
                                </div>
                                <div class="noti-item-info">
                                    <p class="noti-item-text mb-0">{{ $notification->title }}</p>
                                    <span class="noti-item-time">{{ $notification->created_at->diffforhumans() }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        {{ $notifications->links() }}
    @else
        <div class="card">
            <div class="card-body p-5">
                <div class="col-lg-6 m-auto">
                    @include('themes.basic.business.partials.empty', ['empty_classes' => 'empty-lg'])
                </div>
            </div>
        </div>
    @endif
@endsection
