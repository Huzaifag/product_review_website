@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('title', d_trans('Notifications'))
@section('header_title', d_trans('Notifications'))
@section('content')
    @if ($notifications->count() > 0)
        <div class="notifications-lg">
            @foreach ($notifications as $notification)
                @if ($notification->link)
                    <a href="{{ route('admin.notifications.view', $notification->id) }}"
                        class="notification {{ !$notification->status ? 'unread' : '' }}">
                        <div class="notification-icon">
                            <img src="{{ $notification->image }}" alt="{{ $notification->title }}">
                        </div>
                        <div class="notification-info">
                            <p class="notification-title mb-0">{{ $notification->title }}</p>
                            <p class="notification-text mb-0">{{ $notification->created_at->diffforhumans() }}</p>
                        </div>
                    </a>
                @else
                    <div class="notification {{ !$notification->status ? 'unread' : '' }}">
                        <div class="notification-icon">
                            <img src="{{ $notification->image }}" alt="{{ $notification->title }}">
                        </div>
                        <div class="notification-info">
                            <p class="notification-title mb-0">{{ $notification->title }}</p>
                            <p class="notification-text mb-0">{{ $notification->created_at->diffforhumans() }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        {{ $notifications->links() }}
    @else
        <div class="card">
            <div class="card-body col-lg-8 m-auto">
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            </div>
        </div>
    @endif
@endsection
