@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Businesses'))
@section('title', d_trans('Business Categories'))
@section('header_title', d_trans(':business_name Categories', ['business_name' => $business->trans->name]))
@section('back', route('admin.businesses.index'))
@section('business_view', true)
@section('content')
    @include('admin.businesses.includes.tabs')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
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
                <table class="table no-outer-border">
                    <thead>
                        <th>{{ d_trans('Category') }}</th>
                        <th class="text-center">{{ d_trans('Sub Categories') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($tableCategories as $tableCategory)
                            <tr>
                                <td><i class="bi bi-tag-fill me-2"></i>{{ $tableCategory['subCategory']['name'] }}
                                </td>
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
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <form
                                                    action="{{ route('admin.businesses.categories.delete', [$business->id, $tableCategory['subCategory']['id']]) }}"
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
                            @include('admin.partials.empty-table', ['colspan' => 3])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $subCategories->links() }}
@endsection
