@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('title', d_trans('System'))
@section('header_title', d_trans('System'))
@section('page_search', true)
@section('content')
    <div class="sys-settings">
        <div class="row row-cols-1 row-cols-md-2 g-3">
            <div class="col page-search-element">
                <a href="{{ route('admin.system.information.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('System Information') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('View details about your system environment.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.system.maintenance.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Maintenance Mode') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Enable or disable maintenance mode.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.system.addons.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-puzzle"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Addons') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage and install additional features.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.system.admin-panel-style.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-palette"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Admin Panel Style') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Customize the appearance of the admin panel.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.system.editor-images.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="fa-regular fa-image"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Editor Images') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage the uploaded images from the editor.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.system.cronjob.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Cron Job') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Schedule automated tasks for your system.') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
