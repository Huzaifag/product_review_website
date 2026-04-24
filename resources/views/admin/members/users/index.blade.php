@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Users'))
@section('header_title', d_trans('Users'))
@section('create', route('admin.members.users.create'))
@section('content')
    <div class="row g-3 row-cols-md-2 row-cols-xxl-3 mb-4">
        <div class="col">
            <div class="split-stat-card theme-brand-base">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Active') }}</p>
                    <h3 class="split-card-number">{{ $counters['active'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-copper">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Banned') }}</p>
                    <h3 class="split-card-number">{{ $counters['banned'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-person-x"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-clay">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Email Verified') }}</p>
                    <h3 class="split-card-number">{{ $counters['email_verified'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-envelope-check"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-sienna">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Email Unverified') }}</p>
                    <h3 class="split-card-number">{{ $counters['email_unverified'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-envelope-x"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-gold">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('KYC Verified') }}</p>
                    <h3 class="split-card-number">{{ $counters['kyc_verified'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-chat-right-quote"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-sand">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('KYC Unverified') }}</p>
                    <h3 class="split-card-number">{{ $counters['kyc_unverified'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-people"></i>
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
        <style>
            /* --- Split Layout Stat Cards --- */

            .split-stat-card {
                position: relative;
                display: flex;
                align-items: center;
                border-radius: 8px;
                padding: 24px 20px;
                color: #ffffff;
                overflow: hidden;
                min-height: 110px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .split-stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            /* Left Content */
            .split-card-content {
                position: relative;
                z-index: 2;
                flex: 1;
            }

            .split-card-title {
                font-size: 13px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0 0 8px 0;
                opacity: 0.95;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            .split-card-number {
                font-size: 28px;
                font-weight: 700;
                margin: 0;
                line-height: 1;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            /* Right Curved Shape */
            .split-card-icon {
                position: absolute;
                right: 0;
                top: 0;
                height: 100%;
                width: 35%;
                /* Adjusts how wide the curve section is */
                background-color: var(--shape-color);
                border-top-left-radius: 120px;
                /* Creates the curve */
                border-bottom-left-radius: 120px;
                /* Creates the curve */
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 32px;
                z-index: 1;
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Optional hover effect on the shape */
            .split-stat-card:hover .split-card-icon {
                width: 38%;
            }

            /* --- 8 Unique Color Themes --- */

            /* 1. Base Brand Color */
            .theme-brand-base {
                background: linear-gradient(120deg, #ba511d 0%, #d4724a 100%);
                --shape-color: #8a3a12;
            }

            /* 2. Soft Blush Copper */
            .theme-brand-copper {
                background: linear-gradient(120deg, #c96340 0%, #dea080 100%);
                --shape-color: #9a4228;
            }

            /* 3. Warm Peach Clay */
            .theme-brand-clay {
                background: linear-gradient(120deg, #d4845a 0%, #e8b595 100%);
                --shape-color: #ba511d;
            }

            /* 4. Dusty Rose Sienna */
            .theme-brand-sienna {
                background: linear-gradient(120deg, #c05535 0%, #d98870 100%);
                --shape-color: #8f3820;
            }

            /* 5. Soft Amber Gold */
            .theme-brand-gold {
                background: linear-gradient(120deg, #c97a2a 0%, #e0aa6a 100%);
                --shape-color: #9a5518;
            }

            /* 6. Linen Sand */
            .theme-brand-sand {
                background: linear-gradient(120deg, #d4a07a 0%, #e8c9aa 100%);
                --shape-color: #b07045;
            }

            /* 7. Soft Brick */
            .theme-brand-brick {
                background: linear-gradient(120deg, #b84535 0%, #d08070 100%);
                --shape-color: #8a2e20;
            }

            /* 8. Warm Mist Mahogany */
            .theme-brand-mahogany {
                background: linear-gradient(120deg, #9a4020 0%, #c07a5a 100%);
                --shape-color: #6e2a12;
            }
        </style>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
