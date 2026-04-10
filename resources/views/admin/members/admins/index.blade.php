@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Admins'))
@section('header_title', d_trans('Admins'))
@section('create', route('admin.members.admins.create'))
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
                <table class="table">
                    <thead>
                        <th>{{ d_trans('ID') }}</th>
                        <th>{{ d_trans('Details') }}</th>
                        <th class="text-center">{{ d_trans('Registred Date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.members.admins.edit', $admin->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $admin->id }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('admin.members.admins.edit', $admin->id) }}"
                                            class="item-img item-img-sm">
                                            <img src="{{ $admin->getAvatar() }}" alt="{{ $admin->getName() }}">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.members.admins.edit', $admin->id) }}"
                                                class="item-title d-block fw-normal mb-0">{{ $admin->getName() }}</a>
                                            <p class="item-text text-muted small mb-0">{{ $admin->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ dateFormat($admin->created_at) }}</td>
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
                                                    href="{{ route('admin.members.admins.edit', $admin->id) }}">
                                                    <i
                                                        class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit details') }}
                                                </a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.members.admins.destroy', $admin->id) }}"
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
                            @include('admin.partials.empty-table', ['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $admins->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
