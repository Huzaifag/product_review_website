@extends('installer::layouts.app')
@section('title', d_trans('License'))
@section('content')
    <div class="vironeer-steps-body">
        <p class="vironeer-form-info-text">
            {{ d_trans('As part of protecting our products we are building our systems to validate the license for every customer, the license means your purchase code.') }}
        </p>
        <div class="mb-4">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ d_trans('Purchase Code') }}</label>
                    <input type="text" name="purchase_code" class="form-control form-control-md"
                        value="2c0bca37-f609-4733-a06a-f1b150b3b057">
                </div>
                <button class="btn btn-primary btn-md">{{ d_trans('Continue') }}<i
                        class="fas fa-arrow-right ms-2"></i></button>
            </form>
        </div>
        <div class="vironeer-links">
            <h6 class="mb-3">
                <a style="color:red;" href="https://bit.ly/ncave_club" target="_blank">NULLED Forum</a>
            </h6>
        </div>
    </div>
@endsection
