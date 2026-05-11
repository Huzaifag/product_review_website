@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Test Attributes'))
@section('title', d_trans('Test Attributes'))
@section('header_title', d_trans('Test Attributes'))
@section('create', route('admin.test-attributes.create'))
@section('content')
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
                            <th>{{ d_trans('Name') }}</th>
                            <th>{{ d_trans('Type') }}</th>
                            <th>{{ d_trans('Options') }}</th>
                            <th>{{ d_trans('Status') }}</th>
                            <th>{{ d_trans('Date') }}</th>
                            <th>{{ d_trans('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($testAttributes as $testAttribute)
                            <tr>
                                <!-- Index -->
                                <td>{{ $loop->iteration }}</td>

                                <!-- Name -->
                                <td>{{ $testAttribute->name }}</td>

                                <!-- Type -->
                                <td>
                                    @if ($testAttribute->type === 'select')
                                        <span class="badge bg-primary">{{ d_trans('Select') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ d_trans('Text') }}</span>
                                    @endif
                                </td>

                                <!-- Options -->
                                <td style="max-width: 200px;">
                                    @if ($testAttribute->type === 'select' && !empty($testAttribute->options))
                                        @php
                                            $options = is_array($testAttribute->options)
                                                ? $testAttribute->options
                                                : json_decode($testAttribute->options, true);
                                        @endphp

                                        @if (!empty($options))
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($options as $option)
                                                    <span class="badge bg-info text-dark">{{ $option }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td>
                                    @if ($testAttribute->active())
                                        <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ d_trans('Inactive') }}</span>
                                    @endif
                                </td>

                                <!-- Date -->
                                <td>{{ $testAttribute->created_at?->format('d M Y') }}</td>

                                <!-- Actions -->
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $testAttribute->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>

                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $testAttribute->id }}">

                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.test-attributes.edit', $testAttribute->id) }}">
                                                    {{ d_trans('Edit') }}
                                                </a>
                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>
                                                <a class="dropdown-item text-danger"
                                                    href="{{ route('admin.test-attributes.destroy', $testAttribute->id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $testAttribute->id }}').submit();">
                                                    {{ d_trans('Delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Delete Form -->
                                    <form id="delete-form-{{ $testAttribute->id }}"
                                        action="{{ route('admin.test-attributes.destroy', $testAttribute->id) }}"
                                        method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 7])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $testAttributes->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
@endsection
