@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Settings'))
@section('title', d_trans('Captcha Providers'))
@section('header_title', d_trans('Captcha Providers'))
@section('back', route('admin.settings.index'))
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table datatable2">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Logo') }}</th>
                            <th>{{ d_trans('name') }}</th>
                            <th>{{ d_trans('Status') }}</th>
                            <th>{{ d_trans('Last Update') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($captchaProviders as $captchaProvider)
                            <tr>
                                <td>{{ $captchaProvider->id }}</td>
                                <td>
                                    <a href="{{ route('admin.settings.captcha-providers.edit', $captchaProvider->id) }}">
                                        <img src="{{ $captchaProvider->getLogoLink() }}" height="50px" width="50px"
                                            alt="{{ $captchaProvider->name }}">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.captcha-providers.edit', $captchaProvider->id) }}"
                                        class="text-dark">
                                        {{ d_trans($captchaProvider->name) }}
                                    </a>
                                    {{ $captchaProvider->isDefault() ? d_trans('(Default)') : '' }}
                                </td>
                                <td>
                                    @if ($captchaProvider->isActive())
                                        <span class="badge bg-success">{{ $captchaProvider->getStatusName() }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $captchaProvider->getStatusName() }}</span>
                                    @endif
                                </td>
                                <td>{{ dateFormat($captchaProvider->updated_at) }}</td>
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
                                                    href="{{ route('admin.settings.captcha-providers.edit', $captchaProvider->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            @if (!$captchaProvider->isDefault())
                                                <li class="dropdown-divider"></li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.settings.captcha-providers.default', $captchaProvider->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="action-confirm dropdown-item text-success">
                                                            <i
                                                                class="fa-regular fa-bookmark"></i>{{ d_trans('Make Default') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
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
