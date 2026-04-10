@extends(errorsLayout())
@section('title', d_trans('Forbidden'))
@section('code', '403')
@section('message',d_trans('Sorry, you are not authorized to access this resource. Please make sure you have the necessary permissions to view this page.'))
