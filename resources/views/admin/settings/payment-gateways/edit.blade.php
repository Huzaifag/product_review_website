@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Settings'))
@section('title', d_trans('Payment Gateways'))
@section('header_title', d_trans('Edit Payment Gateway'))
@section('back', route('admin.settings.payment-gateways.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.payment-gateways.update', $paymentGateway->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row row-cols-1 g-4 mb-2">
                            <div class="col-12">
                                <x-admin.image-uploader name="logo" label="{{ d_trans('Choose Logo') }}"
                                    src="{{ $paymentGateway->getLogoLink() }}" width="150px" />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Name') }}</label>
                                <input type="text" name="name" class="form-control form-control-md"
                                    value="{{ $paymentGateway->name }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Status') }} </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-height="45px"
                                    @checked($paymentGateway->isActive())>
                            </div>
                            @if ($paymentGateway->mode)
                                <div class="col-lg-6">
                                    <label class="form-label">{{ d_trans('Mode') }} </label>
                                    <select name="mode" class="form-select form-select-md">
                                        @foreach (\App\Models\PaymentGateway::getAvailableModes() as $mode)
                                            <option value="{{ $mode }}" @selected($paymentGateway->mode == $mode)>
                                                {{ ucfirst($mode) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="{{ $paymentGateway->mode ? 'col-lg-6' : 'col-lg-12' }}">
                                <label class="form-label">{{ d_trans('Fees') }}</label>
                                <div class="input-group input-group-md">
                                    <input type="number" name="fees" class="form-control form-control-md"
                                        placeholder="0" value="{{ $paymentGateway->fees }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (!$paymentGateway->isManual())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">{{ d_trans('Currency') }}</div>
                        <div class="card-body p-4">
                            <div class="row g-2 align-items-center">
                                <div class="col-12">
                                    <input type="text" name="currency" class="form-control form-control-md"
                                        placeholder="{{ d_trans('Currency Code (USD)') }}"
                                        value="{{ $paymentGateway->currency }}">
                                </div>
                                <div class="col-lg-5">
                                    <x-input-price size="md" value="1" :disabled=true :integer=true />
                                </div>
                                <div class="col text-center d-none d-lg-inline">
                                    <div class="fs-1">=</div>
                                </div>
                                <div class="col-lg-5">
                                    <input type="number" name="rate" class="form-control form-control-md"
                                        value="{{ $paymentGateway->rate }}" step="any" placeholder="0.00">
                                </div>
                            </div>
                            <div class="note note-warning mb-0 mt-3">
                                <i
                                    class="fa-regular fa-circle-question me-2"></i>{{ d_trans('Use this in case you want to charge users with different currency or the gateway does not support your website currency') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($paymentGateway->parameters)
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">{{ d_trans('Parameters') }}</div>
                        <div class="card-body p-4">
                            <div class="row g-3 mb-2">
                                @foreach ($paymentGateway->parameters as $key => $parameter)
                                    <div class="col-lg-12">
                                        <label class="form-label capitalize">{{ d_trans($parameter->label) }}</label>
                                        @if ($parameter->type == 'route')
                                            <div class="input-group">
                                                <input id="input-link-{{ $key }}" type="text"
                                                    value="{{ url($parameter->content) }}"
                                                    class="form-control form-control-md" readonly>
                                                <button type="button" class="btn btn-soft px-3 btn-copy"
                                                    data-clipboard-target="#input-link-{{ $key }}"><i
                                                        class="far fa-clone"></i></button>
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <input id="input-text-{{ $key }}" type="text"
                                                    value="{{ $parameter->content }}" class="form-control form-control-md"
                                                    readonly>
                                                <button type="button" class="btn btn-soft px-3 btn-copy"
                                                    data-clipboard-target="#input-text-{{ $key }}"><i
                                                        class="far fa-clone"></i></button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12">
                @if (!$paymentGateway->isManual())
                    <div class="card">
                        <div class="card-header">{{ d_trans('Credentials') }}</div>
                        <div class="card-body p-4">
                            <div class="row g-3 mb-2">
                                @foreach ($paymentGateway->credentials as $key => $value)
                                    <div class="col-lg-12">
                                        <label class="form-label capitalize">
                                            {{ d_trans(str_replace('_', ' ', $key)) }}
                                        </label>
                                        <input type="text" name="credentials[{{ $key }}]"
                                            value="{{ demo($value) }}" class="form-control form-control-md">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">{{ d_trans('Instructions') }}</div>
                        <div class="card-body p-4">
                            <textarea name="instructions" class="editor">{{ $paymentGateway->instructions }}</textarea>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
    @endpush
@endsection
