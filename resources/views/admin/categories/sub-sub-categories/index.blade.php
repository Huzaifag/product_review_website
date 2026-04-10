@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Categories'))
@section('title', d_trans('Sub Sub Categories'))
@section('header_title', d_trans('Sub Sub Categories'))
@section('create', route('admin.categories.sub-sub-categories.create'))
@section('content')
    @include('admin.categories.includes.tabs', ['active' => 'sub_sub'])
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                @if (request('sub_category'))
                    <input type="hidden" name="sub_category" value="{{ request('sub_category') }}">
                @endif
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="sub_category" class="selectpicker" title="{{ d_trans('Sub Category') }}"
                            data-live-search="true">
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @selected($subCategory->id == request('sub_category'))>
                                    {{ $subCategory->trans->name }}
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
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Name') }}</th>
                            <th>{{ d_trans('Sub Category') }}</th>
                            <th class="text-center">{{ d_trans('Views') }}</th>
                            <th class="text-center">{{ d_trans('Published date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subSubCategories as $subSubCategory)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.categories.sub-sub-categories.edit', $subSubCategory->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $subSubCategory->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.sub-sub-categories.edit', $subSubCategory->id) }}"
                                        class="item-title d-block fw-normal mb-0">
                                        <i class="fa-solid fa-tag me-2"></i>{{ $subSubCategory->trans->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.sub-categories.edit', $subSubCategory->subCategory->id) }}"
                                        class="item-title d-block fw-normal mb-0">
                                        <i
                                            class="fa-solid fa-tags me-2"></i>{{ $subSubCategory->subCategory->trans->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-dark">{{ $subSubCategory->views }}</span>
                                </td>
                                <td class="text-center">{{ dateFormat($subSubCategory->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item" href="{{ $subSubCategory->getLink() }}"
                                                    target="_blank"><i
                                                        class="fa-solid fa-arrow-up-right-from-square"></i>{{ d_trans('Preview') }}</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.categories.sub-sub-categories.edit', $subSubCategory->id) }}">
                                                    <i
                                                        class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.businesses.index', ['sub_sub_category' => $subSubCategory->id]) }}">
                                                    <i class="fa-solid fa-briefcase"></i>{{ d_trans('Businesses') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form
                                                    action="{{ route('admin.categories.sub-sub-categories.destroy', $subSubCategory->id) }}"
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
                            @include('admin.partials.empty-table', ['colspan' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $subSubCategories->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
@endsection
