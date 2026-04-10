@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Business Owners'))
@section('header_title', d_trans('Edit Business Owner :name', ['name' => $owner->getName()]))
@section('back', route('admin.members.business-owners.index'))
@section('content')
    @include('admin.members.business-owners.includes.widgets')
    <div class="settings-box v2">
        @include('admin.members.business-owners.includes.sidebar')
        <div class="settings-content">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h5 class="settings-card-title">{{ d_trans('Login Logs') }}</h5>
                </div>
                <div class="card">
                    <div class="card-header border-bottom">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="row g-3">
                                <div class="col-12 col-lg-10">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="{{ d_trans('Search...') }}" value="{{ request('search') }}">
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
                            <table class="table">
                                <thead>
                                    <th><i class="fa-solid fa-hashtag"></i></th>
                                    <th>{{ d_trans('IP') }}</th>
                                    <th>{{ d_trans('Country') }}</th>
                                    <th>{{ d_trans('Location') }}</th>
                                    <th>{{ d_trans('Browser') }}</th>
                                    <th>{{ d_trans('OS') }}</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @forelse ($loginLogs as $loginLog)
                                        <tr>
                                            <td>{{ $loginLog->id }}</td>
                                            <td><strong>{{ demo($loginLog->ip) }}</strong></td>
                                            <td>{{ $loginLog->country }}</td>
                                            <td>
                                                <i class="fa-solid fa-map-location-dot me-2"></i>{{ $loginLog->location }}
                                            </td>
                                            <td>{{ $loginLog->browser }}</td>
                                            <td>{{ $loginLog->os }}</td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                                        aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.members.business-owners.logs.delete', [$owner->id, $loginLog->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="action-confirm dropdown-item text-danger">
                                                                    <i class="far fa-trash-alt"></i>{{ d_trans('Delete') }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        @include('admin.partials.empty-table', ['colspan' => 6])
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{ $loginLogs->links() }}
        </div>
    </div>
@endsection
