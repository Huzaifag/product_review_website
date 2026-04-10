@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Newsletter'))
@section('title', d_trans('Subscribers'))
@section('header_title', d_trans('Newsletter Subscribers'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-soft w-100">{{ d_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table sortable">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Email') }}</th>
                            <th class="text-center">{{ d_trans('Date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td><i class="fa-solid fa-hashtag me-1"></i>{{ $subscriber->id }}</td>
                                <td>{{ demo($subscriber->email) }}</td>
                                <td class="text-center">{{ dateFormat($subscriber->created_at) }}</td>
                                <td class="text-end">
                                    <form action="{{ route('admin.newsletter.subscribers.destroy', $subscriber->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger action-confirm"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $subscribers->links() }}
@endsection
