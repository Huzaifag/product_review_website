@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Settings'))
@section('title', d_trans('Taxes'))
@section('header_title', d_trans('Taxes'))
@section('back', route('admin.settings.index'))
@section('create', route('admin.settings.taxes.create'))
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table datatable">
                    <thead>
                        <tr>
                            <th class="tb-w-2x">#</th>
                            <th>{{ d_trans('Name') }}</th>
                            <th>{{ d_trans('Rate') }}</th>
                            <th>{{ d_trans('Countries') }}</th>
                            <th>{{ d_trans('Created date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($taxes as $tax)
                            <tr>
                                <td>{{ $tax->id }}</td>
                                <td>
                                    <a href="{{ route('admin.settings.taxes.edit', $tax->id) }}" class="text-dark">
                                        {{ $tax->trans->name }}
                                    </a>
                                </td>
                                <td>{{ $tax->rate }}%</td>
                                <td>
                                    @if (count($tax->countries) > 3)
                                        {{ d_trans(':count Countries', ['count' => count($tax->countries)]) }}
                                    @else
                                        {{ implode(
                                            ', ',
                                            array_map(function ($country) {
                                                return countries($country);
                                            }, $tax->countries),
                                        ) }}
                                    @endif
                                </td>
                                <td>{{ dateFormat($tax->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.settings.taxes.edit', $tax->id) }}"><i
                                                        class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}</a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.settings.taxes.destroy', $tax->id) }}"
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
@endsection
