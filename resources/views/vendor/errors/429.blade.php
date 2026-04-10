@extends(errorsLayout())
@section('title', d_trans('Too Many Requests'))
@section('code', '429')
@section('message', d_trans('Sorry, you have exceeded the rate limit for accessing this resource. Please wait a few minutes and try again.'))
