@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Categories'))
@section('header_title', d_trans('Categories'))
@section('breadcrumbs', Breadcrumbs::render('business.categories'))
@section('add_modal', true)
@section('content')
    <div class="dashboard-table-container">
        <div class="position-relative box dashboard-box">
            <div class="dashboard-table">
                <div class="table-search">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-3">
                            <div class="col-lg-10">
                                <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                    class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                            </div>
                            <div class="col-12 col-md-4 col-xl-2">
                                <div class="row row-cols-2 g-3">
                                    <div class="col">
                                        <button class="btn btn-primary btn-md w-100">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <a href="{{ url()->current() }}" class="btn btn-outline-primary btn-md w-100">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-container">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>{{ d_trans('Category') }}</th>
                                <th class="text-center">{{ d_trans('Sub Categories') }}</th>
                                <th class="text-end">{{ d_trans('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tableCategories as $tableCategory)
                                <tr>
                                    <td><i class="bi bi-tag-fill me-2"></i>{{ $tableCategory['subCategory']['name'] }}</td>
                                    <td class="text-center w-50">
                                        <div class="row g-2 justify-content-center">
                                            @foreach ($tableCategory['subSubCategories'] as $subSubCategory)
                                                <div class="col-auto">
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-tag-fill me-2"></i>{{ $subSubCategory }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown custom-drop position-static ">
                                            <a class="dropdown-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm"
                                                aria-labelledby="navbarDropdown">
                                                <li>
                                                    <form
                                                        action="{{ route('business.categories.destroy', $tableCategory['subCategory']['slug']) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item action-confirm text-danger">
                                                            <i class="fa fa-trash"></i>{{ d_trans('Delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @include('themes.basic.business.partials.empty-table', ['colspan' => 3])
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $subCategories->links() }}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 p-0 mb-4">
                    <h1 class="modal-title fs-5" id="addModalLabel">{{ d_trans('Add New Category') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <form action="{{ route('business.categories.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div id="category" class="col-12">
                                <select class="selectpicker selectpicker-md" name="category" data-size="5"
                                    data-live-search="true" title="{{ d_trans('Select Category') }}" required>
                                    @foreach ($modalSubCategories as $modalSubCategory)
                                        <option value="{{ $modalSubCategory->slug }}">{{ $modalSubCategory->trans->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="subCategory" class="col-12 d-none">
                                <select class="selectpicker selectpicker-md" name="sub_categories[]" data-size="5"
                                    data-live-search="true" title="{{ d_trans('Select Sub Categories') }}" multiple
                                    required>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary btn-md w-100">{{ d_trans('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            "use strict";

            let categorySelect = $('#category select'),
                subCategory = $('#subCategory'),
                subCategorySelect = $('#subCategory select');

            categorySelect.on('change', function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('business.categories.load.sub-categories') }}",
                    method: 'POST',
                    data: {
                        category: $(this).val(),
                    },
                    success: function(response) {
                        if (!$.isEmptyObject(response.error)) {
                            toastr.error(response.error);
                        } else {
                            subCategorySelect.selectpicker('destroy');
                            subCategorySelect.empty();
                            response.forEach(function(data) {
                                subCategorySelect.append(
                                    `<option value="${data.slug}">${data.name}</option>`
                                );
                            });
                            subCategorySelect.prop('disabled', false);
                            subCategorySelect.selectpicker();
                            subCategorySelect.addClass('selectpicker');
                            subCategory.removeClass('d-none');
                        }
                    },
                    error: function(request, status, error) {
                        toastr.error(error);
                    }
                });
            })
        </script>
    @endpush
@endsection
