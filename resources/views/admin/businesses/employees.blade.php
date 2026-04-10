@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Businesses'))
@section('title', d_trans('Business Employees'))
@section('header_title', d_trans(':business_name Employees', ['business_name' => $business->trans->name]))
@section('back', route('admin.businesses.index'))
@section('business_view', true)
@section('content')
    @include('admin.businesses.includes.tabs')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="role" class="selectpicker" title="{{ d_trans('Role') }}">
                            @foreach ($roles as $role)
                                <option value="{{ $role->value }}" @selected(request('role') == $role->value)>
                                    {{ $role->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            @foreach ($statuses as $statusKey => $statusValue)
                                <option value="{{ $statusKey }}" @selected(request('status') == $statusKey)>
                                    {{ $statusValue }}</option>
                            @endforeach
                        </select>
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
                <table class="table no-outer-border">
                    <thead>
                        <th>{{ d_trans('Employee') }}</th>
                        <th class="text-center">{{ d_trans('Role') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr>
                                <td>
                                    @if ($employee->owner)
                                        @php
                                            $owner = $employee->owner;
                                        @endphp
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="{{ route('admin.members.business-owners.edit', $owner->id) }}"
                                                class="item-img item-img-sm">
                                                <img src="{{ $owner->getAvatar() }}" alt="{{ $owner->getName() }}">
                                            </a>
                                            <div>
                                                <a href="{{ route('admin.members.business-owners.edit', $owner->id) }}"
                                                    class="item-title d-block fw-normal mb-0">{{ $owner->getName() }}</a>
                                                <p class="item-text text-muted small mb-0">{{ $owner->email }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="item-img item-img-sm">
                                                <img src="{{ \App\Classes\AvatarGenerator::gravatar($employee->email) }}"
                                                    alt="{{ $employee->email }}">
                                            </div>
                                            <div>
                                                <div class="item-title d-block fw-normal mb-0">{{ $employee->email }}</div>
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
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <form
                                                    action="{{ route('admin.businesses.employees.delete', [$business->id, $employee->id]) }}"
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
    {{ $employees->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
