@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('title', d_trans('Advertisements'))
@section('header_title', d_trans('Advertisements'))
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table datatable2 w-100">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Position') }}</th>
                            <th>{{ d_trans('Status') }}</th>
                            <th>{{ d_trans('Last update') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($advertisements as $advertisement)
                            <tr>
                                <td>{{ $advertisement->id }}</td>
                                <td>
                                    <a href="{{ route('admin.advertisements.edit', $advertisement->id) }}" class="text-dark">
                                        <i class="fas fa-ad me-2"></i>{{ d_trans($advertisement->position) }}
                                    </a>
                                </td>
                                <td>
                                    @if ($advertisement->isActive())
                                        <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ d_trans('Disabled') }}</span>
                                    @endif
                                </td>
                                <td>{{ dateFormat($advertisement->updated_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.advertisements.edit', $advertisement->id) }}"><i
                                                        class="fa fa-edit me-2"></i>{{ d_trans('Edit') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
@endsection
