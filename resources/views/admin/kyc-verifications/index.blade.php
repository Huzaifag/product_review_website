@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('KYC Verifications'))
@section('header_title', d_trans('KYC Verifications'))
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-warning">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Pending') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-success">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Approved') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['approved'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Rejected') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['rejected'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                @if (request('owner'))
                    <input type="hidden" name="owner" value="{{ request('owner') }}">
                @endif
                @if (request('user'))
                    <input type="hidden" name="user" value="{{ request('user') }}">
                @endif
                <div class="row g-3">
                    <div class="col-12 col-lg-5">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="document_type" class="selectpicker" title="{{ d_trans('Document Type') }}">
                            @foreach ($documentTypes as $documentKey => $documentValue)
                                <option value="{{ $documentKey }}" @selected(request('document_type') == $documentKey)>
                                    {{ $documentValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            @foreach ($statuses as $statusKey => $statusValue)
                                <option value="{{ $statusKey }}" @selected(request('status') == $statusKey)>
                                    {{ $statusValue }}
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
                        <th><i class="fa-solid fa-hashtag"></i></th>
                        <th>{{ d_trans('Details') }}</th>
                        <th class="text-center">{{ d_trans('Document Type') }}</th>
                        <th class="text-center">{{ d_trans('Document Number') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Submitted Date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($kycVerifications as $kycVerification)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.kyc-verifications.show', $kycVerification->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $kycVerification->id }}
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $editLink = $kycVerification->user
                                            ? route('admin.members.users.edit', $kycVerification->guard->id)
                                            : route('admin.members.business-owners.edit', $kycVerification->guard->id);
                                    @endphp
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ $editLink }}" class="item-img item-img-sm">
                                            <img src="{{ $kycVerification->guard->getAvatar() }}"
                                                alt="{{ $kycVerification->guard->getName() }}">
                                        </a>
                                        <div>
                                            <a href="{{ $editLink }}"
                                                class="item-title d-block fw-normal mb-0">{{ $kycVerification->guard->getName() }}</a>
                                            <p class="item-text text-muted small mb-0">
                                                {{ $kycVerification->guard->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $kycVerification->getDocumentType() }}</td>
                                <td class="text-center">{{ $kycVerification->document_number }}</td>
                                <td class="text-center">
                                    @if ($kycVerification->isPending())
                                        <div class="badge bg-warning">
                                            {{ $kycVerification->getStatusName() }}
                                        </div>
                                    @elseif ($kycVerification->isApproved())
                                        <div class="badge bg-success">
                                            {{ $kycVerification->getStatusName() }}
                                        </div>
                                    @elseif($kycVerification->isRejected())
                                        <div class="badge bg-danger">
                                            {{ $kycVerification->getStatusName() }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($kycVerification->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.kyc-verifications.show', $kycVerification->id) }}">
                                                    <i class="fas fa-desktop"></i>{{ d_trans('Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form
                                                    action="{{ route('admin.kyc-verifications.destroy', $kycVerification->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="action-confirm dropdown-item text-danger"><i
                                                            class="far fa-trash-alt"></i>{{ d_trans('Delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 7])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $kycVerifications->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
