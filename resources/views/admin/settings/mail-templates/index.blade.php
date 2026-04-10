@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Mail Templates'))
@section('header_title', d_trans('Mail Templates'))
@section('back', route('admin.settings.index'))
@section('content')
    <div class="dashboard-tabs">
        <a href="{{ route('admin.settings.mail-templates.index') }}"
            class="dashboard-tabs-item {{ $group == 'general' ? 'current' : '' }}">
            <i class="fa-regular fa-envelope"></i><span class="ms-2">{{ d_trans('General Templates') }}</span>
        </a>
        <a href="{{ route('admin.settings.mail-templates.group', 'user') }}"
            class="dashboard-tabs-item {{ $group == 'user' ? 'current' : '' }}">
            <i class="fa-regular fa-envelope"></i><span class="ms-2">{{ d_trans('User Templates') }}</span>
        </a>
        <a href="{{ route('admin.settings.mail-templates.group', 'business') }}"
            class="dashboard-tabs-item {{ $group == 'business' ? 'current' : '' }}">
            <i class="fa-regular fa-envelope"></i><span class="ms-2">{{ d_trans('Business Templates') }}</span>
        </a>
        <a href="{{ route('admin.settings.mail-templates.group', 'admin') }}"
            class="dashboard-tabs-item {{ $group == 'admin' ? 'current' : '' }}">
            <i class="fa-regular fa-envelope"></i><span class="ms-2">{{ d_trans('Admin Templates') }}</span>
        </a>
    </div>
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
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Name') }}</th>
                            <th class="text-center">{{ d_trans('Status') }}</th>
                            <th class="text-center">{{ d_trans('Last Update') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mailTemplates as $mailTemplate)
                            <tr>
                                <td>{{ $mailTemplate->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('admin.settings.mail-templates.edit', $mailTemplate->id) }}"
                                            class="item-img item-img-sm">
                                            <svg class="mt-1" fill="{{ config('settings.admin.colors.primary_color') }}"
                                                height="50px" width="50px" version="1.1" id="Icons"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"
                                                xml:space="preserve">
                                                <g>
                                                    <path
                                                        d="M26,4.1V3c0-1.7-1.3-3-3-3H9C7.3,0,6,1.3,6,3v1.1C3.7,4.6,2,6.6,2,9v14c0,2.8,2.2,5,5,5h18c2.8,0,5-2.2,5-5V9 C30,6.6,28.3,4.6,26,4.1z M28,9v0.4l-2,1.2V6.2C27.2,6.6,28,7.7,28,9z M8,3c0-0.6,0.4-1,1-1h14c0.6,0,1,0.4,1,1v8.9l-8,4.9l-8-4.9 V3z M6,6.2v4.5L4,9.4V9C4,7.7,4.8,6.6,6,6.2z" />
                                                    <path
                                                        d="M11,6h7c0.6,0,1-0.4,1-1s-0.4-1-1-1h-7c-0.6,0-1,0.4-1,1S10.4,6,11,6z" />
                                                    <path
                                                        d="M11,10h3c0.6,0,1-0.4,1-1s-0.4-1-1-1h-3c-0.6,0-1,0.4-1,1S10.4,10,11,10z" />
                                                </g>
                                            </svg>
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.settings.mail-templates.edit', $mailTemplate->id) }}"
                                                class="item-title d-block mb-1">
                                                {{ d_trans($mailTemplate->name) }}</a>
                                            <p class="item-text text-muted small mb-0">{{ $mailTemplate->subject }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($mailTemplate->isActive())
                                        <span class="badge bg-success">{{ $mailTemplate->getStatusName() }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $mailTemplate->getStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($mailTemplate->updated_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.settings.mail-templates.edit', $mailTemplate->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
@endsection
