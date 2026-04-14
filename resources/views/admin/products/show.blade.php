@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Product Details'))
@section('header_title', d_trans(':product_name Details', ['product_name' => $product->name]))
@section('back', route('admin.products.index'))
@section('content')
    @include('admin.products.includes.tabs')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">{{ d_trans('Product Details') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.products.partials.form', ['buttonLabel' => d_trans('Save Changes')])
                    </form>
                </div>
            </div>

            @if ($product->images->count() > 0)
                <div class="card mt-4">
                    <div class="card-header border-bottom">
                        <h5 class="mb-0">{{ d_trans('Product Images') }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $mainImagePath = $product->image ?: ($product->images->first()?->path ?? null);
                            $galleryImages = $product->images->reject(function ($image) use ($mainImagePath) {
                                return $image->path === $mainImagePath;
                            });
                        @endphp
                        <div class="d-flex flex-wrap gap-3">
                            @if ($mainImagePath)
                                <img src="{{ asset($mainImagePath) }}" alt="{{ $product->name }}" width="96" height="96" class="rounded-3 border p-1">
                            @endif
                            @foreach ($galleryImages as $image)
                                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" width="96" height="96" class="rounded-3 border p-1">
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-0 pb-3 mb-3 border-bottom">
                            <h5 class="mb-1">{{ $product->name }}</h5>
                            <p class="text-muted small mb-0">{{ $product->slug }}</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <strong>{{ d_trans('Brand') }}</strong>
                            <span>{{ $product->brand_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <strong>{{ d_trans('Category') }}</strong>
                            <span>{{ $product->category->trans->name ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <strong>{{ d_trans('Sub Category') }}</strong>
                            <span>{{ $product->subCategory->trans->name ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <strong>{{ d_trans('Overall Grade') }}</strong>
                            <span>{{ $product->overall_grade ? str_replace('_', ' ', ucfirst($product->overall_grade)) : '--' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <strong>{{ d_trans('Status') }}</strong>
                            @if ($product->is_active)
                                <span class="badge bg-success">{{ d_trans('Active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ d_trans('Inactive') }}</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <strong>{{ d_trans('Featured') }}</strong>
                            @if ($product->is_featured)
                                <span class="badge bg-c21">{{ d_trans('Yes') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ d_trans('No') }}</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <strong>{{ d_trans('Created At') }}</strong>
                            <span>{{ dateFormat($product->created_at) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
