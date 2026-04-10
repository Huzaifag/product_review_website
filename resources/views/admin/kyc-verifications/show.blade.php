@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('KYC Verifications'))
@section('title', d_trans('KYC Verifications'))
@section('header_title', d_trans('KYC Verification #:kyc_verification_id', ['kyc_verification_id' => $kycVerification->id]))
@section('back', route('admin.kyc-verifications.index'))
@section('content')
    @if ($kycVerification->isApproved())
        <div class="note note-success mb-3">
            <div class="row g-3">
                <div class="col-auto">
                    <i class="bi bi-check-circle note-icon fa-3x"></i>
                </div>
                <div class="col-auto">
                    <h4 class="alert-heading">{{ d_trans('Request Approved') }}</h4>
                    <p class="mb-0">{{ d_trans('This request has been approved and the KYC status is verified') }}</p>
                </div>
            </div>
        </div>
    @elseif ($kycVerification->isRejected())
        <div class="note note-danger mb-3">
            <div class="row g-3">
                <div class="col-auto">
                    <i class="bi bi-x-circle note-icon fa-3x"></i>
                </div>
                <div class="col-auto">
                    <h4 class="alert-heading">{{ d_trans('Request Rejected') }}</h4>
                    <p class="mb-0">{{ d_trans('This request has been rejected because of the reason below') }}</p>
                    <hr />
                    <i class="mb-0">{{ $kycVerification->rejection_reason }}</i>
                </div>
            </div>
        </div>
    @else
        <div class="card mb-3">
            <div class="card-header">{{ d_trans('Take Action') }}</div>
            <div class="card-body">
                <div class="row row-cols-auto g-3">
                    <div class="col">
                        <form action="{{ route('admin.kyc-verifications.approve', $kycVerification->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-success btn-md px-5 action-confirm">
                                <i class="fa-regular fa-circle-check me-1"></i>
                                <span>{{ d_trans('Approve') }}</span>
                            </button>
                        </form>
                    </div>
                    <div class="col">
                        <button id="kycRejectButton" class="btn btn-outline-danger btn-md px-5">
                            <i class="fa-regular fa-circle-xmark me-1"></i>
                            <span>{{ d_trans('Reject') }}</span>
                        </button>
                    </div>
                    <div id="kycRejectForm" class="col-12" style="display: none;">
                        <form action="{{ route('admin.kyc-verifications.reject', $kycVerification->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ d_trans('Rejection Reason') }}</label>
                                <textarea name="rejection_reason" class="form-control" rows="6" required></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="email_notification" class="form-check-input">
                                <label class="form-check-label">{{ d_trans('Send Email Notification') }}</label>
                            </div>
                            <button class="btn btn-danger btn-md px-5 action-confirm">
                                <span>{{ d_trans('Submit') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @php
        $editLink = $kycVerification->user
            ? route('admin.members.users.edit', $kycVerification->guard->id)
            : route('admin.members.business-owners.edit', $kycVerification->guard->id);
    @endphp
    <div class="card mb-3">
        <div class="card-header">{{ d_trans('Account details') }}</div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-lg-6">
                    <label class="form-label">{{ d_trans('First Name') }} </label>
                    <input type="firstname" name="firstname" class="form-control form-control-md"
                        value="{{ $kycVerification->guard->firstname }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label class="form-label">{{ d_trans('Last Name') }} </label>
                    <input type="lastname" name="lastname" class="form-control form-control-md"
                        value="{{ $kycVerification->guard->lastname }}" disabled>
                </div>
                <div class="col-lg-12">
                    <label class="form-label">{{ d_trans('Username') }} </label>
                    <input type="text" name="username" class="form-control form-control-md"
                        value="{{ $kycVerification->guard->username }}" disabled>
                </div>
                <div class="col-lg-12">
                    <label class="form-label">{{ d_trans('E-mail Address') }} </label>
                    <input type="email" name="email" class="form-control form-control-md"
                        value="{{ demo($kycVerification->guard->email) }}" disabled>
                </div>
            </div>
            <a href="{{ $editLink }}" target="_blank" class="btn btn-outline-primary btn-md w-100"><i
                    class="fa-solid fa-up-right-from-square me-2"></i>{{ d_trans('View full details') }}</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">{{ d_trans('Documents') }}</div>
        <div class="card-body">
            <div class="row g-3">
                @foreach ($kycVerification->documents as $key => $document)
                    @if ($document)
                        <div class="col-12 col-lg-6 col-xl">
                            <div class="border p-3 rounded-3 bg-light h-100">
                                <h5 class="border-bottom pb-3 mb-3 text-center">
                                    {{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}
                                </h5>
                                <div class="mb-3">
                                    <a href="{{ route('admin.kyc-verifications.document', [$kycVerification->id, $key]) }}"
                                        target="_blank">
                                        <img src="{{ route('admin.kyc-verifications.document', [$kycVerification->id, $key]) }}"
                                            alt="{{ $document }}" class="rounded-3" width="100%" height="220px">
                                    </a>
                                </div>
                                <a href="{{ route('admin.kyc-verifications.document', [$kycVerification->id, $key]) }}"
                                    target="_blank" class="btn btn-outline-secondary btn-md w-100 mb-3"><i
                                        class="fa-solid fa-up-right-from-square me-2"></i>{{ d_trans('View Document') }}</a>
                                <form
                                    action="{{ route('admin.kyc-verifications.download', [$kycVerification->id, $key]) }}"
                                    method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-md w-100"><i
                                            class="fa-solid fa-download me-2"></i>{{ d_trans('Download') }}</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            "use strict";
            let kycRejectButton = $('#kycRejectButton'),
                kycRejectForm = $('#kycRejectForm');
            kycRejectButton.on('click', function() {
                kycRejectForm.toggle();
            })
        </script>
    @endpush
@endsection
