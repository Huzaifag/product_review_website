@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Brands'))
@section('title', d_trans('Main Brands'))
@section('header_title', d_trans('Main Brands'))
@section('create', route('admin.brands.create'))
@section('content')
    @include('admin.brands.includes.tabs', ['active' => 'main'])
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
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Logo') }}</th>
                            <th>{{ d_trans('Name') }}</th>
                            <th class="text-center">{{ d_trans('Website') }}</th>
                            <th class="text-center">{{ d_trans('Description') }}</th>
                            <th class="text-center">{{ d_trans('Status') }}</th>
                            <th class="text-center">{{ d_trans('Published date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($brand->logo)
                                        <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}" width="100"
                                            class="table-image">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td class="text-center">
                                    @if ($brand->website_url)
                                        <a href="{{ $brand->website_url }}" target="_blank" class="text-decoration-underline">
                                            {{ d_trans('Visit Website') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $brand->description }}</td>
                                <td class="text-center">
                                    @if ($brand->active())
                                        <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ d_trans('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $brand->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $brand->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $brand->id }}">
                                            <li><a class="dropdown-item" href="{{ route('admin.brands.edit', $brand->id) }}">{{ d_trans('Edit') }}</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.brands.show', $brand->id) }}">{{ d_trans('View') }}</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="{{ route('admin.brands.destroy', $brand->id) }}"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $brand->id }}').submit();">
                                                {{ d_trans('Delete') }}
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                                <form id="delete-form-{{ $brand->id }}" action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $brands->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
@endsection
