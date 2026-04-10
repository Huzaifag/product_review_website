@extends(errorsLayout())
@section('title', d_trans('Unauthorized'))
@section('code', '401')
@section('message',d_trans('Sorry, you are not authorized to access this resource. Please make sure you have the necessary permissions to view this page.'))
