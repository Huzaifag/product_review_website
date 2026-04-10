@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Users'))
@section('header_title', d_trans('Edit User :name', ['name' => $user->getName()]))
@section('back', route('admin.members.users.index'))
@section('content')
    @include('admin.members.users.includes.widgets')
    <div class="settings-box v2">
        @include('admin.members.users.includes.sidebar')
        <div class="settings-content">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h5 class="settings-card-title">
                        {{ d_trans('Send Mail To :email', ['email' => demo($user->email)]) }}
                    </h5>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('admin.members.users.sendmail.send', $user->id) }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Subject') }} </label>
                                <input type="subject" name="subject" class="form-control form-control-md" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Reply to') }} </label>
                                <input type="email" name="reply_to" class="form-control form-control-md"
                                    value="{{ authAdmin()->email }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Message') }} </label>
                                <textarea name="message" class="editor"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary btn-md px-4">{{ d_trans('Send') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
    @endpush
@endsection
