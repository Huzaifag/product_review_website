@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Product Test'))
@section('header_title', d_trans('Product Test'))
@section('back', route('admin.products.index'))
@section('content')
    @include('admin.products.includes.tabs')

    <div class="card mt-4">
        <div class="card-header border-bottom">
            <h5 class="mb-0">{{ d_trans('Product Test') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.lab-tests.update', $product->id) }}" method="POST">
                @csrf

                {{-- Hidden: product_id, category_id, sub_category_id --}}
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                <input type="hidden" name="sub_category_id" value="{{ $product->sub_category_id }}">

                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-8">
                        <label class="form-label">{{ d_trans('Test Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="product_test_name" class="form-control form-control-md"
                            value="{{ old('product_test_name', $productTest->name ?? $product->name) }}" required>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ d_trans('Status') }}</label>
                        <select name="product_test_status" class="form-select form-select-md">
                            <option value="active"
                                {{ old('product_test_status', $productTest->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                {{ d_trans('Active') }}</option>
                            <option value="inactive"
                                {{ old('product_test_status', $productTest->status ?? 'active') === 'inactive' ? 'selected' : '' }}>
                                {{ d_trans('Inactive') }}</option>
                        </select>
                    </div>

                    {{-- ── Test Attributes (data JSON) ── --}}
                    @if (isset($testAttributes) && $testAttributes->count())
                        <div class="col-12 mt-2">
                            <h6 class="mb-3 border-bottom pb-2">{{ d_trans('Test Attributes') }}</h6>
                            <div class="row g-3">
                                @foreach ($testAttributes as $attr)
                                    @php
                                        $savedValue = $productTest->data[$attr->id] ?? null;
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $attr->name }}</label>

                                        @if ($attr->type === 'boolean')
                                            <div class="form-check form-switch mt-1">
                                                <input class="form-check-input" type="checkbox"
                                                    name="test_attribute[{{ $attr->id }}]"
                                                    id="attr_{{ $attr->id }}" value="1"
                                                    {{ old('test_attribute.' . $attr->id, $savedValue) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="attr_{{ $attr->id }}">
                                                    {{ d_trans('Yes') }}
                                                </label>
                                            </div>
                                        @elseif($attr->type === 'select' && $attr->options)
                                            <select name="test_attribute[{{ $attr->id }}]"
                                                class="form-select form-select-md">
                                                <option value="">{{ d_trans('Select') }}</option>
                                                @foreach ($attr->options as $option)
                                                    <option value="{{ $option }}"
                                                        {{ old('test_attribute.' . $attr->id, $savedValue) == $option ? 'selected' : '' }}>
                                                        {{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif($attr->type === 'number')
                                            <input type="number" step="any" name="test_attribute[{{ $attr->id }}]"
                                                class="form-control form-control-md"
                                                value="{{ old('test_attribute.' . $attr->id, $savedValue) }}">
                                        @else
                                            <input type="text" name="test_attribute[{{ $attr->id }}]"
                                                class="form-control form-control-md"
                                                value="{{ old('test_attribute.' . $attr->id, $savedValue) }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                {{ d_trans('No active test attributes found.') }}
                                <a href="{{ route('admin.test-attributes.create') }}" class="alert-link">
                                    {{ d_trans('Create one') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Save --}}
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary btn-md">
                            {{ d_trans('Save Product Test') }}
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
