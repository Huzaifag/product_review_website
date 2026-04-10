@extends('installer::layouts.app')
@section('title', d_trans('Database'))
@section('content')
    <div class="vironeer-steps-body">
        <p class="vironeer-form-info-text">
            {{ d_trans('Enter your database details. You can read the docs included with the script files to learn how to create the database, please do not use the hashtag "#" or spaces on the database details.') }}
        </p>
        <form action="{{ route('install.database.details') }}" method="POST">
            @csrf
            <div class="row row-cols-1 g-3 mb-4">
                <div class="col">
                    <label class="form-label">{{ d_trans('Database host') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-server"></i></span>
                        <input type="text" name="db_host" class="form-control form-control-md remove-spaces"
                            placeholder="{{ d_trans('Enter database host') }}" value="{{ old('db_host') ?? 'localhost' }}"
                            required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Database name') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-question-circle"></i></span>
                        <input type="text" name="db_name" class="form-control form-control-md remove-spaces"
                            placeholder="{{ d_trans('Enter database name') }}" value="{{ old('db_name') }}"
                            autocomplete="off" required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Database username') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" name="db_user" class="form-control form-control-md remove-spaces"
                            placeholder="{{ d_trans('Enter database username') }}" value="{{ old('db_user') }}"
                            autocomplete="off" required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Database password') }} </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="db_pass" class="form-control form-control-md remove-spaces"
                            placeholder="{{ d_trans('Enter database password') }}" autocomplete="off">
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-md">{{ d_trans('Continue') }}<i
                    class="fas fa-arrow-right ms-2"></i></button>
        </form>
    </div>
@endsection
