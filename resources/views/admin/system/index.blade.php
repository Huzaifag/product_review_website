@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('title', d_trans('System'))
@section('header_title', d_trans('System'))
@section('page_search', true)
@section('content')
    <div class="sys-settings">
    <div class="row row-cols-1 row-cols-md-2 g-3">
        <!-- System Information -->
        <div class="col page-search-element">
            <a href="{{ route('admin.system.information.index') }}" class="premium-card">
                <div class="card-glow"></div>
                <div class="premium-card-body">
                    <div class="icon-wrapper bg-soft-info">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="content-wrapper">
                        <h6 class="card-title">{{ d_trans('System Information') }}</h6>
                        <p class="card-description">{{ d_trans('View details about your system environment.') }}</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right arrow-hint"></i>
            </a>
        </div>

        <!-- Maintenance Mode -->
        <div class="col page-search-element">
            <a href="{{ route('admin.system.maintenance.index') }}" class="premium-card">
                <div class="card-glow"></div>
                <div class="premium-card-body">
                    <div class="icon-wrapper bg-soft-warning">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div class="content-wrapper">
                        <h6 class="card-title">{{ d_trans('Maintenance Mode') }}</h6>
                        <p class="card-description">{{ d_trans('Enable or disable maintenance mode.') }}</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right arrow-hint"></i>
            </a>
        </div>

        <!-- Addons -->
        <div class="col page-search-element">
            <a href="{{ route('admin.system.addons.index') }}" class="premium-card">
                <div class="card-glow"></div>
                <div class="premium-card-body">
                    <div class="icon-wrapper bg-soft-secondary">
                        <i class="bi bi-puzzle"></i>
                    </div>
                    <div class="content-wrapper">
                        <h6 class="card-title">{{ d_trans('Addons') }}</h6>
                        <p class="card-description">{{ d_trans('Manage and install additional features.') }}</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right arrow-hint"></i>
            </a>
        </div>

        <!-- Admin Panel Style -->
        <div class="col page-search-element">
            <a href="{{ route('admin.system.admin-panel-style.index') }}" class="premium-card">
                <div class="card-glow"></div>
                <div class="premium-card-body">
                    <div class="icon-wrapper bg-soft-primary">
                        <i class="bi bi-palette"></i>
                    </div>
                    <div class="content-wrapper">
                        <h6 class="card-title">{{ d_trans('Admin Panel Style') }}</h6>
                        <p class="card-description">{{ d_trans('Customize the appearance of the admin panel.') }}</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right arrow-hint"></i>
            </a>
        </div>

        <!-- Editor Images -->
        <div class="col page-search-element">
            <a href="{{ route('admin.system.editor-images.index') }}" class="premium-card">
                <div class="card-glow"></div>
                <div class="premium-card-body">
                    <div class="icon-wrapper bg-soft-success">
                        <i class="fa-regular fa-image"></i>
                    </div>
                    <div class="content-wrapper">
                        <h6 class="card-title">{{ d_trans('Editor Images') }}</h6>
                        <p class="card-description">{{ d_trans('Manage the uploaded images from the editor.') }}</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right arrow-hint"></i>
            </a>
        </div>

        <!-- Cron Job -->
        <div class="col page-search-element">
            <a href="{{ route('admin.system.cronjob.index') }}" class="premium-card">
                <div class="card-glow"></div>
                <div class="premium-card-body">
                    <div class="icon-wrapper bg-soft-danger">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="content-wrapper">
                        <h6 class="card-title">{{ d_trans('Cron Job') }}</h6>
                        <p class="card-description">{{ d_trans('Schedule automated tasks for your system.') }}</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right arrow-hint"></i>
            </a>
        </div>
    </div>
</div>
    <style>
        :root {
            --card-bg: #ffffff;
            --card-radius: 16px;
            --primary-color: #4361ee;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sys-settings-wrapper {
            padding: 10px 0;
        }

        .premium-card {
            position: relative;
            display: block;
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--card-radius);
            padding: 1.5rem;
            text-decoration: none !important;
            overflow: hidden;
            height: 100%;
            transition: var(--transition);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
        }

        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border-color: rgba(67, 97, 238, 0.2);
        }

        .premium-card-body {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            z-index: 2;
        }

        /* Icon Styling */
        .icon-wrapper {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .premium-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(-5deg);
        }

        /* Color Variations */
        .bg-soft-primary {
            background: #eef2ff;
            color: #4361ee;
        }

        .bg-soft-success {
            background: #ecfdf5;
            color: #10b981;
        }

        .bg-soft-info {
            background: #f0f9ff;
            color: #0ea5e9;
        }

        .bg-soft-warning {
            background: #fffbeb;
            color: #f59e0b;
        }

        /* Text Content */
        .card-title {
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 1.05rem;
        }

        .card-description {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 0;
            line-height: 1.4;
        }

        /* Decorative Arrow */
        .arrow-hint {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%) translateX(10px);
            opacity: 0;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .premium-card:hover .arrow-hint {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        /* The "Glow" Effect */
        .card-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(67, 97, 238, 0.05), transparent);
            pointer-events: none;
        }
    </style>
@endsection
