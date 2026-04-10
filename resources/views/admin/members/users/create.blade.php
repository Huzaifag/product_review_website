@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Members'))
@section('title', d_trans('Users'))
@section('header_title', d_trans('New User'))
@section('back', route('admin.members.users.index'))
@section('form', true)
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.members.users.store') }}" method="POST">
                @csrf
                <div class="row row-cols-1 g-3 mb-2">
                    <div class="col">
                        <label class="form-label">{{ d_trans('First Name') }} </label>
                        <input type="firstname" name="firstname" class="form-control form-control-md"
                            value="{{ old('firstname') }}" maxlength="50">
                    </div>
                    <div class="col">
                        <label class="form-label">{{ d_trans('Last Name') }} </label>
                        <input type="lastname" name="lastname" class="form-control form-control-md"
                            value="{{ old('lastname') }}" maxlength="50">
                    </div>
                    <div class="col">
                        <label class="form-label">{{ d_trans('Username') }} </label>
                        <input type="text" name="username" class="form-control form-control-md"
                            value="{{ old('username') }}" minlength="3" required>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ d_trans('Email Address') }} </label>
                        <input type="email" name="email" class="form-control form-control-md"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ d_trans('Password') }} </label>
                        <div class="input-group">
                            <input id="randomPasswordInput" type="text" class="form-control form-control-md"
                                name="password" required>
                            <button class="btn btn-soft btn-copy" type="button"
                                data-clipboard-target="#randomPasswordInput"><i class="far fa-clone"></i></button>
                            <button id="randomPasswordBtn" class="btn btn-soft" type="button"><i
                                    class="fa-solid fa-rotate me-2"></i>{{ d_trans('Generate') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
