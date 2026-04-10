@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Employees'))
@section('header_title', d_trans('Employees'))
@section('breadcrumbs', Breadcrumbs::render('business.employees'))
@section('add_modal', true)
@section('content')
    <div class="dashboard-table-container">
        <div class="position-relative box dashboard-box">
            <div class="dashboard-table">
                <div class="table-search">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                    class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                            </div>
                            <div class="col-lg-2">
                                <select name="role" class="selectpicker selectpicker-md" title="{{ d_trans('Role') }}">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->value }}" @selected(request('role') == $role->value)>
                                            {{ $role->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select name="status" class="selectpicker selectpicker-md" title="{{ d_trans('Status') }}">
                                    @foreach ($statuses as $statusKey => $statusValue)
                                        <option value="{{ $statusKey }}" @selected(request('status') == $statusKey)>
                                            {{ $statusValue }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-xl-2">
                                <div class="row row-cols-2 g-3">
                                    <div class="col">
                                        <button class="btn btn-primary btn-md w-100">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <a href="{{ url()->current() }}" class="btn btn-outline-primary btn-md w-100">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-container">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>{{ d_trans('Employee') }}</th>
                                <th class="text-center">{{ d_trans('Role') }}</th>
                                <th class="text-center">{{ d_trans('Status') }}</th>
                                <th class="text-end">{{ d_trans('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                <tr>
                                    <td>
                                        @if ($employee->owner)
                                            @php
                                                $owner = $employee->owner;
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between gap-3">
                                                <div class="item-sm d-flex align-items-center gap-3">
                                                    <div class="item-img flex-shrink-0">
                                                        <img src="{{ $owner->getAvatar() }}"
                                                            alt="{{ $owner->getName() }}">
                                                    </div>
                                                    <div class="item-info d-flex flex-column justify-content-center">
                                                        <h4 class="item-title">{{ $owner->getName() }}</h4>
                                                        <div class="text-muted">{{ $owner->email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center justify-content-between gap-3">
                                                <div class="item-sm d-flex align-items-center gap-3">
                                                    <div class="item-img flex-shrink-0">
                                                        <img src="{{ \App\Classes\AvatarGenerator::gravatar($employee->email) }}"
                                                            alt="{{ $employee->email }}">
                                                    </div>
                                                    <div class="item-info d-flex flex-column justify-content-center">
                                                        <div class="text-muted">{{ $employee->email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $employee->role->label() }}
                                    </td>
                                    <td class="text-center">
                                        @if ($employee->isActive())
                                            <span class="badge bg-success">{{ $employee->getStatusName() }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ $employee->getStatusName() }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown custom-drop position-static ">
                                            <a class="dropdown-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm"
                                                aria-labelledby="navbarDropdown">
                                                <li>
                                                    <form action="{{ route('business.employees.destroy', $employee->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item action-confirm text-danger">
                                                            <i class="fa fa-trash"></i>{{ d_trans('Delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @include('themes.basic.business.partials.empty-table', ['colspan' => 4])
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $employees->links() }}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 p-0 mb-4">
                    <h1 class="modal-title fs-5" id="addModalLabel">{{ d_trans('Add New Employee') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="alert alert-info">
                        <p>
                            <strong>{{ d_trans('Note:') }}</strong>
                            {{ d_trans("An invitation link will be sent to the employee's email. They must accept the invitation and join the platform.") }}
                        </p>
                        <strong>{{ d_trans('Roles Overview:') }}</strong><br>
                        <ul class="mb-0">
                            <li><strong>{{ d_trans('Admin:') }}</strong>
                                {{ d_trans('Full access to all business settings and reviews.') }}</li>
                            <li><strong>{{ d_trans('Employee:') }}</strong>
                                {{ d_trans('Can manage reviews only and reply to them.') }}</li>
                        </ul>
                    </div>
                    <form action="{{ route('business.employees.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Email Address') }}</label>
                                <input type="email" name="email" class="form-control form-control-md"
                                    placeholder="name@example.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Role') }}</label>
                                <select name="role" class="form-select form-select-md" required>
                                    @foreach ($roles as $role)
                                        <option value='{{ $role->value }}'>{{ $role->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary btn-md w-100">{{ d_trans('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
