@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Navigation'))
@section('title', d_trans('Navbar Links'))
@section('header_title', d_trans('New Navbar Link'))
@section('back', route('admin.navigation.navbar-links.index'))
@section('form', true)
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.navigation.navbar-links.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-2">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-md" value="{{ old('name') }}"
                            required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Link') }} </label>
                        <input type="link" name="link" class="form-control form-control-md" placeholder="/"
                            value="{{ old('link') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Type') }} </label>
                        <select name="type" class="form-select form-select-md">
                            @foreach (\App\Models\NavbarLink::getAvailableTypes() as $key => $value)
                                <option value="{{ $key }}" @selected(old('type') == $key)>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
