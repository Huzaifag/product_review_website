@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Settings'))
@section('title', d_trans('Extensions'))
@section('header_title', d_trans('Extensions'))
@section('back', route('admin.settings.index'))
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table datatable2">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Logo') }}</th>
                            <th>{{ d_trans('name') }}</th>
                            <th>{{ d_trans('Status') }}</th>
                            <th>{{ d_trans('Last Update') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($extensions as $extension)
                            <tr>
                                <td>{{ $extension->id }}</td>
                                <td>
                                    <a href="{{ route('admin.settings.extensions.edit', $extension->id) }}">
                                        <img src="{{ $extension->getLogoLink() }}" height="45px" width="45px"
                                            alt="{{ $extension->name }}">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.extensions.edit', $extension->id) }}"
                                        class="text-dark">
                                        {{ d_trans($extension->name) }}
                                    </a>
                                </td>
                                <td>
                                    @if ($extension->isActive())
                                        <span class="badge bg-success">{{ $extension->getStatusName() }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $extension->getStatusName() }}</span>
                                    @endif
                                </td>
                                <td>{{ dateFormat($extension->updated_at) }}</td>
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
                                                    href="{{ route('admin.settings.extensions.edit', $extension->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
