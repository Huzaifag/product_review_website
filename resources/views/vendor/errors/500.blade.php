@extends(errorsLayout())
@section('title', d_trans('Server Error'))
@section('code', '500')
@section('message', d_trans('Sorry, there was an internal server error, and we were unable to fulfill your request. Please try again later.'))
