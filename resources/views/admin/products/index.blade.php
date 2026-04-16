@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('Products'))
@section('header_title', d_trans('Products'))
@section('content')
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i>{{ d_trans('Add Product') }}
        </a>
    </div>

    <div class="row g-3 row-cols-md-2 row-cols-xxl-4 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-success">
                <div class="vironeer-counter-card-icon"><i class="fa-solid fa-check"></i></div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Active') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['active'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-icon"><i class="fa-solid fa-ban"></i></div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Inactive') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['inactive'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c21">
                <div class="vironeer-counter-card-icon"><i class="fa-solid fa-certificate"></i></div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Featured') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['featured'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-26">
                <div class="vironeer-counter-card-icon"><i class="fa-solid fa-flask-vial"></i></div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Lab Verified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['lab_verified'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="category" class="selectpicker" title="{{ d_trans('Category') }}">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == "$category->id")>
                                    {{ $category->trans->name ?? $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="sub_category" class="selectpicker" title="{{ d_trans('Sub Category') }}">
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @selected(request('sub_category') == "$subCategory->id")>
                                    {{ $subCategory->trans->name ?? $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            <option value="1" @selected(request('status') === '1')>{{ d_trans('Active') }}</option>
                            <option value="0" @selected(request('status') === '0')>{{ d_trans('Inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="featured" class="selectpicker" title="{{ d_trans('Featured') }}">
                            <option value="1" @selected(request('featured') === '1')>{{ d_trans('Yes') }}</option>
                            <option value="0" @selected(request('featured') === '0')>{{ d_trans('No') }}</option>
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
                        <th>{{ d_trans('Name') }}</th>
                        <th class="text-center">{{ d_trans('Brand') }}</th>
                        <th class="text-center">{{ d_trans('Category') }}</th>
                        <th class="text-center">{{ d_trans('Sub Category') }}</th>
                        <th class="text-center">{{ d_trans('Grade') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Added date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $product->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="item-title d-block fw-normal mb-0">
                                        {{ $product->name }}
                                    </a>
                                    <p class="item-text text-muted small mb-0">{{ $product->slug }}</p>
                                </td>
                                <td class="text-center">{{ $product->brand->name ?? '-' }}</td>
                                <td class="text-center">{{ $product->category->trans->name ?? '-' }}</td>
                                <td class="text-center">{{ $product->subCategory->trans->name ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($product->overall_grade)
                                        <span class="badge bg-c21">{{ str_replace('_', ' ', ucfirst($product->overall_grade)) }}</span>
                                    @else
                                        <span>--</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($product->is_active)
                                        <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ d_trans('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($product->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.products.show', $product->id) }}">
                                                    <i class="fas fa-desktop"></i>{{ d_trans('View Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">
                                                    <i class="fas fa-pen"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider" /></li>
                                            <li>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
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
                            @include('admin.partials.empty-table', ['colspan' => 9])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush

    {{ $products->links() }}
@endsection
