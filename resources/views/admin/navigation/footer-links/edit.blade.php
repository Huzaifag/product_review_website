@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Navigation'))
@section('title', d_trans('Footer Links'))
@section('header_title', d_trans('Edit Footer Link'))
@section('back', route('admin.navigation.footer-links.index'))
@section('form', true)
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.navigation.footer-links.update', $footerLink->id) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3 mb-2">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ $footerLink->name }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Link') }} </label>
                        <input type="link" name="link" class="form-control form-control-md" placeholder="/"
                            value="{{ $footerLink->link }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Type') }} </label>
                        <select name="type" class="form-select form-select-md">
                            @foreach (\App\Models\FooterLink::getAvailableTypes() as $key => $value)
                                <option value="{{ $key }}" @selected($footerLink->type == $key)>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
