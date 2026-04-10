@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Users'))
@section('header_title', d_trans('Users'))
@section('create', route('admin.members.users.create'))
@section('content')
    <div class="row g-3 row-cols-md-2 row-cols-xxl-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-success">
                <div class="vironeer-counter-card-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Active') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['active'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-icon">
                    <i class="fa fa-ban"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Banned') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['banned'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c19">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-envelope-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Email Verified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['email_verified'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c20">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-envelope-open"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Email Unverified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['email_unverified'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c9">
                <div class="vironeer-counter-card-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('KYC Verified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['kyc_verified'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c6">
                <div class="vironeer-counter-card-icon">
                    <i class="fas fa-user-alt-slash"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('KYC Unverified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['kyc_unverified'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-4">
                        <select name="email_status" class="selectpicker" title="{{ d_trans('Email Status') }}">
                            @foreach (\App\Models\User::getAvailableEmailStatuses() as $key => $value)
                                <option value="{{ $key }}" @selected(request('email_status') == "$key")>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="kyc_status" class="selectpicker" title="{{ d_trans('KYC Status') }}">
                            @foreach (\App\Models\User::getAvailableKycStatuses() as $key => $value)
                                <option value="{{ $key }}" @selected(request('kyc_status') == "$key")>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="account_status" class="selectpicker" title="{{ d_trans('Account Status') }}">
                            @foreach (\App\Models\User::getAvailableStatuses() as $key => $value)
                                <option value="{{ $key }}" @selected(request('account_status') == "$key")>
                                    {{ $value }}
                                </option>
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
                <table class="table">
                    <thead>
                        <th>{{ d_trans('ID') }}</th>
                        <th>{{ d_trans('Details') }}</th>
                        <th>{{ d_trans('Username') }}</th>
                        <th class="text-center">{{ d_trans('Email status') }}</th>
                        <th class="text-center">{{ d_trans('KYC status') }}</th>
                        <th class="text-center">{{ d_trans('Account status') }}</th>
                        <th class="text-center">{{ d_trans('Registered Date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.members.users.edit', $user->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $user->id }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                            class="item-img item-img-sm">
                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                                class="item-title d-block fw-normal mb-0">{{ $user->getName() }}</a>
                                            <p class="item-text text-muted small mb-0">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ '@' . $user->username ?? '--' }}</td>
                                <td class="text-center">
                                    @if ($user->isEmailVerified())
                                        <span class="badge bg-c19">{{ $user->getEmailStatusName() }}</span>
                                    @else
                                        <span class="badge bg-c20">{{ $user->getEmailStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($user->hasKycVerified())
                                        <span class="badge bg-c9">{{ $user->getKycStatusName() }}</span>
                                    @else
                                        <span class="badge bg-c6">{{ $user->getKycStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($user->isActive())
                                        <span class="badge bg-success">{{ $user->getStatusName() }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $user->getStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($user->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item" href="{{ $user->getProfileLink() }}"
                                                    target="_blank">
                                                    <i class="fas fa-external-link-alt"></i>{{ d_trans('View Profile') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.members.users.edit', $user->id) }}">
                                                    <i
                                                        class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit details') }}
                                                </a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-primary" target="_blank"
                                                    href="{{ route('admin.members.users.login', $user->id) }}">
                                                    <i
                                                        class="fa-solid fa-arrow-right-to-bracket"></i>{{ d_trans('Login as user') }}
                                                </a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.members.users.destroy', $user->id) }}"
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
                            @include('admin.partials.empty-table', ['colspan' => 8])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $users->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
