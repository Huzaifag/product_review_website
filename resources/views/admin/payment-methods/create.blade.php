@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Payment Methods'))
@section('title', d_trans('New Payment Method'))
@section('header_title', d_trans('New Payment Method'))
@section('back', route('admin.payment-methods.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.payment-methods.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header">{{ d_trans('Actions') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Status') }}</label>
                        <input type="checkbox" name="is_active" data-toggle="toggle" data-height="40px"
                            data-on="{{ d_trans('Active') }}" data-off="{{ d_trans('Disabled') }}"
                            @checked(old('is_active') ?? true)>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ d_trans('Environment') }}</label>
                        <select name="environment" class="form-select form-select-md">
                            <option value="live" @selected(old('environment') === 'live')>{{ d_trans('Live') }}</option>
                            <option value="sandbox" @selected(old('environment') === 'sandbox')>{{ d_trans('Sandbox') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">{{ d_trans('Method Details') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" placeholder="{{ d_trans('e.g., Stripe Gateway') }}" autofocus
                            required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Type') }}</label>
                        <select name="type" class="form-select form-select-md" id="paymentType" required>
                            <option value="">{{ d_trans('Select payment type...') }}</option>
                            @if ($paymentTypes)
                                @foreach ($paymentTypes as $typeKey => $typeLabel)
                                    <option value="{{ $typeKey }}" @selected(old('type') == $typeKey)>{{ $typeLabel }}
                                    </option>
                                @endforeach
                            @else
                                <option value="stripe" @selected(old('type') == 'stripe')>{{ d_trans('Stripe') }}</option>
                                <option value="paypal" @selected(old('type') == 'paypal')>{{ d_trans('PayPal') }}</option>
                                <option value="razorpay" @selected(old('type') == 'razorpay')>{{ d_trans('Razorpay') }}</option>
                            @endif

                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Description') }}</label>
                        <textarea name="description" class="form-control form-control-md" rows="3"
                            placeholder="{{ d_trans('Optional description for internal reference') }}">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>{{ d_trans('Credentials') }}</span>
                <span class="badge bg-soft-info">{{ d_trans('Stored securely as JSON') }}</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3" id="credentialsContainer">
                    @php
                        $oldCredentials = old('credentials', []);
                        $credentialRows = count($oldCredentials) > 0 ? $oldCredentials : [['key' => '', 'value' => '']];
                    @endphp

                    @foreach ($credentialRows as $index => $credential)
                        <div class="col-12 credential-row" data-index="{{ $index }}">
                            <div class="input-group">
                                <input type="text" name="credentials[{{ $index }}][key]" class="form-control"
                                    placeholder="{{ d_trans('Credential Key') }}" value="{{ $credential['key'] ?? '' }}"
                                    required>
                                <input type="text" name="credentials[{{ $index }}][value]" class="form-control"
                                    placeholder="{{ d_trans('Credential Value') }}"
                                    value="{{ $credential['value'] ?? '' }}" required>
                                @if ($index > 0)
                                    <button type="button" class="btn btn-danger remove-credential"
                                        title="{{ d_trans('Remove') }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-12">
                        <button id="addCredential" type="button" class="btn btn-dark btn-md">
                            <i class="fa fa-plus me-1"></i>
                            {{ d_trans('Add credential field') }}
                        </button>
                    </div>
                </div>
                <div class="form-text mt-2">
                    <i class="fa fa-info-circle me-1"></i>
                    {{ d_trans('Common keys: publishable_key, secret_key, client_id, merchant_id, etc.') }}
                </div>
            </div>
        </div>
    </form>

    @push('top_scripts')
        <script>
            "use strict";
            let credentialIndex = {{ count($oldCredentials) > 0 ? count($oldCredentials) : 1 }};
            const credentialKeyText = @json(d_trans('Credential Key'));
            const credentialValueText = @json(d_trans('Credential Value'));
            const credentialRemoveText = @json(d_trans('Remove'));

            document.addEventListener('DOMContentLoaded', function() {
                // Add credential field
                document.getElementById('addCredential').addEventListener('click', function() {
                    const container = document.getElementById('credentialsContainer');
                    const row = document.createElement('div');
                    row.className = 'col-12 credential-row';
                    row.dataset.index = credentialIndex;
                    row.innerHTML = `
                        <div class="input-group">
                            <input type="text" name="credentials[${credentialIndex}][key]" class="form-control" 
                                placeholder="${credentialKeyText}" required>
                            <input type="text" name="credentials[${credentialIndex}][value]" class="form-control" 
                                placeholder="${credentialValueText}" required>
                            <button type="button" class="btn btn-danger remove-credential" title="${credentialRemoveText}">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    `;
                    container.appendChild(row);
                    credentialIndex++;

                    // Attach remove event to new button
                    row.querySelector('.remove-credential').addEventListener('click', removeCredential);
                });

                // Remove credential field
                document.querySelectorAll('.remove-credential').forEach(btn => {
                    btn.addEventListener('click', removeCredential);
                });

                function removeCredential(e) {
                    const row = e.target.closest('.credential-row');
                    if (document.querySelectorAll('.credential-row').length > 1) {
                        row.remove();
                    } else {
                        // Clear inputs instead of removing last row
                        row.querySelectorAll('input').forEach(input => input.value = '');
                    }
                }

                // Optional: Show/hide fields based on payment type
                const paymentTypeSelect = document.getElementById('paymentType');
                if (paymentTypeSelect) {
                    paymentTypeSelect.addEventListener('change', function() {
                        const type = this.value;
                        // Example: Pre-fill common credential keys based on type
                        const commonCredentials = {
                            'stripe': [{
                                key: 'publishable_key',
                                value: ''
                            }, {
                                key: 'secret_key',
                                value: ''
                            }],
                            'paypal': [{
                                key: 'client_id',
                                value: ''
                            }, {
                                key: 'client_secret',
                                value: ''
                            }],
                            'razorpay': [{
                                key: 'key_id',
                                value: ''
                            }, {
                                key: 'key_secret',
                                value: ''
                            }]
                        };

                        if (commonCredentials[type] && document.querySelectorAll('.credential-row').length ===
                            1) {
                            const container = document.getElementById('credentialsContainer');
                            container.innerHTML = '';
                            credentialIndex = 0;
                            commonCredentials[type].forEach(cred => {
                                const event = new Event('click');
                                document.getElementById('addCredential').dispatchEvent(event);
                                setTimeout(() => {
                                    const lastRow = container.lastElementChild;
                                    if (lastRow) {
                                        lastRow.querySelector('input[name*="[key]"]').value =
                                            cred.key;
                                    }
                                }, 10);
                            });
                        }
                    });
                }
            });
        </script>
    @endpush

    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
    @endpush
@endsection
