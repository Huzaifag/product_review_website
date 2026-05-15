@extends('admin.layouts.app')
@section('title', d_trans('Dashboard'))
@section('header_title', d_trans('Dashboard'))
@section('content')

    @if (!config('settings.smtp.status'))
        <div class="dash-alert dash-alert-warning mb-4">
            <div class="dash-alert-icon">
                <i class="bi bi-envelope-exclamation"></i>
            </div>
            <div class="dash-alert-body">
                <h5 class="dash-alert-title">{{ d_trans('SMTP Is Not Enabled') }}</h5>
                <p class="dash-alert-text">{{ d_trans('SMTP is not enabled, set it now to be able to recover the password and use all the features that needs to send an email.') }}</p>
            </div>
            <a href="{{ route('admin.settings.smtp.index') }}" class="dash-alert-btn">
                {{ d_trans('Setup SMTP') }} <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    @endif

    @if (licenseType(2) && config('settings.subscription.status'))
        <div class="row g-4 my-4">
            <div class="col-12 col-md-4">
                <div class="kpi-card kpi-earnings">
                    <div class="kpi-card-glow"></div>
                    <div class="kpi-card-inner">
                        <div class="kpi-icon-wrap">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="kpi-meta">
                            <span class="kpi-label">{{ d_trans('Total Earnings') }}</span>
                            <h2 class="kpi-value counter" data-target="{{ $counters['earnings'] }}">{{ getAmount($counters['earnings']) }}</h2>
                        </div>
                    </div>
                    <div class="kpi-badge"><i class="bi bi-graph-up-arrow me-1"></i>Revenue</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="kpi-card kpi-subscriptions">
                    <div class="kpi-card-glow"></div>
                    <div class="kpi-card-inner">
                        <div class="kpi-icon-wrap">
                            <i class="bi bi-gem"></i>
                        </div>
                        <div class="kpi-meta">
                            <span class="kpi-label">{{ d_trans('Subscriptions') }}</span>
                            <h2 class="kpi-value counter" data-target="{{ $counters['subscriptions'] }}">0</h2>
                        </div>
                    </div>
                    <div class="kpi-badge"><i class="bi bi-people me-1"></i>Active Plans</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="kpi-card kpi-transactions">
                    <div class="kpi-card-glow"></div>
                    <div class="kpi-card-inner">
                        <div class="kpi-icon-wrap">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div class="kpi-meta">
                            <span class="kpi-label">{{ d_trans('Transactions') }}</span>
                            <h2 class="kpi-value counter" data-target="{{ $counters['transactions'] }}">0</h2>
                        </div>
                    </div>
                    <div class="kpi-badge"><i class="bi bi-credit-card me-1"></i>Payments</div>
                </div>
            </div>
        </div>
    @endif

    {{-- Stat Grid --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['products'] }}">0</div>
                    <div class="stat-label">{{ d_trans('Total Products') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-violet">
                <div class="stat-icon"><i class="bi bi-clipboard-data"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['product_tests'] }}">0</div>
                    <div class="stat-label">{{ d_trans('Total Tests') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-teal">
                <div class="stat-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['categories'] }}">0</div>
                    <div class="stat-label">{{ d_trans('Total Categories') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-cyan">
                <div class="stat-icon"><i class="bi bi-diagram-3"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['subcategories'] }}">0</div>
                    <div class="stat-label">{{ d_trans('SubCategories') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-orange">
                <div class="stat-icon"><i class="bi bi-award"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['brands'] }}">0</div>
                    <div class="stat-label">{{ d_trans('Brands') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-rose">
                <div class="stat-icon"><i class="bi bi-chat-square-quote"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['reviews'] }}">0</div>
                    <div class="stat-label">{{ d_trans('User Reviews') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-indigo">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['users'] }}">0</div>
                    <div class="stat-label">{{ d_trans('Users') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="bi bi-person-check"></i></div>
                <div class="stat-body">
                    <div class="stat-number counter" data-target="{{ $counters['kyc_verifications'] }}">0</div>
                    <div class="stat-label">{{ d_trans('KYC Verified') }}</div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>
    </div>

    {{-- Charts + Lists --}}
    <div class="row g-4 my-4">
        <div class="col-12 col-lg-8">
            <div class="dash-card h-100">
                <div class="dash-card-header">
                    <div class="dash-card-title">
                        <span class="dash-card-dot dot-blue"></span>
                        {{ d_trans('New Users This Month') }}
                    </div>
                    <a href="{{ route('admin.members.users.index') }}" class="dash-card-link">{{ d_trans('View All') }} <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="dash-card-body">
                    <canvas id="users-chart" class="chart" style="height:240px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="dash-card h-100 p-0">
                <div class="dash-card-header px-4 pt-4">
                    <div class="dash-card-title">
                        <span class="dash-card-dot dot-violet"></span>
                        {{ d_trans('Recent Users') }}
                    </div>
                    <a href="{{ route('admin.members.users.index') }}" class="dash-card-link">{{ d_trans('View All') }} <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="dash-card-body p-0">
                    @if ($users->count() > 0)
                        <ul class="dash-list">
                            @foreach ($users as $user)
                                <li class="dash-list-item">
                                    <a href="{{ route('admin.members.users.edit', $user->id) }}" class="dash-list-avatar">
                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}">
                                    </a>
                                    <div class="dash-list-info">
                                        <a href="{{ route('admin.members.users.edit', $user->id) }}" class="dash-list-name">{{ $user->getName() }}</a>
                                        <span class="dash-list-meta">{{ $user->created_at->diffforhumans() }}</span>
                                    </div>
                                    <a href="{{ route('admin.members.users.edit', $user->id) }}" class="dash-list-action">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-5 text-center text-muted">
                            @include('admin.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 my-4">
        <div class="col-12 col-lg-4">
            <div class="dash-card h-100 p-0">
                <div class="dash-card-header px-4 pt-4">
                    <div class="dash-card-title">
                        <span class="dash-card-dot dot-orange"></span>
                        {{ d_trans('Recent Products') }}
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="dash-card-link">{{ d_trans('View All') }} <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="dash-card-body p-0">
                    @if ($products->count() > 0)
                        <ul class="dash-list">
                            @foreach ($products as $product)
                                <li class="dash-list-item">
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="dash-list-avatar dash-list-avatar-square">
                                        <img src="{{ asset($product->getImageLink()) }}" alt="{{ $product->name }}">
                                    </a>
                                    <div class="dash-list-info">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="dash-list-name">{{ $product->name }}</a>
                                        <span class="dash-list-meta">{{ $product->created_at->diffforhumans() }}</span>
                                    </div>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="dash-list-action">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-5 text-center text-muted">
                            @include('admin.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="dash-card h-100">
                <div class="dash-card-header">
                    <div class="dash-card-title">
                        <span class="dash-card-dot dot-orange"></span>
                        {{ d_trans('Products Added This Month') }}
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="dash-card-link">{{ d_trans('View All') }} <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="dash-card-body">
                    <canvas id="products-chart" class="chart" style="height:240px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div class="dash-card-title">
                        <span class="dash-card-dot dot-rose"></span>
                        {{ d_trans('Reviews Submitted This Month') }}
                    </div>
                </div>
                <div class="dash-card-body">
                    <canvas id="reviews-chart" class="chart" style="height:220px"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('top_scripts')
        <script>
            "use strict";
            const chartsConfig = @json($charts);
        </script>
    @endpush

    @push('styles_libs')
        <style>
            /* =========================================
               DASHBOARD — Modern Design System
            ========================================= */

            /* Alert */
            .dash-alert {
                display: flex;
                align-items: center;
                gap: 16px;
                padding: 18px 24px;
                border-radius: 14px;
                flex-wrap: wrap;
            }
            .dash-alert-warning {
                background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
                border: 1px solid #fcd34d;
            }
            .dash-alert-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                background: #fbbf24;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                flex-shrink: 0;
            }
            .dash-alert-body { flex: 1; min-width: 200px; }
            .dash-alert-title { font-size: 15px; font-weight: 700; color: #92400e; margin: 0 0 4px; }
            .dash-alert-text { font-size: 13px; color: #78350f; margin: 0; line-height: 1.5; }
            .dash-alert-btn {
                padding: 9px 20px;
                border-radius: 10px;
                background: #f59e0b;
                color: #fff;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                white-space: nowrap;
                transition: background 0.2s;
            }
            .dash-alert-btn:hover { background: #d97706; color: #fff; }

            /* ---- KPI Cards (Earnings/Subscriptions/Transactions) ---- */
            .kpi-card {
                position: relative;
                border-radius: 20px;
                padding: 28px 24px 24px;
                overflow: hidden;
                color: #fff;
                min-height: 140px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .kpi-card-glow {
                position: absolute;
                top: -40px;
                right: -40px;
                width: 160px;
                height: 160px;
                border-radius: 50%;
                background: rgba(255,255,255,0.12);
                pointer-events: none;
            }
            .kpi-card-inner { display: flex; align-items: center; gap: 18px; }
            .kpi-icon-wrap {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                background: rgba(255,255,255,0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 26px;
                flex-shrink: 0;
                backdrop-filter: blur(4px);
            }
            .kpi-meta { flex: 1; }
            .kpi-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; opacity: 0.85; display: block; margin-bottom: 6px; }
            .kpi-value { font-size: 32px; font-weight: 800; margin: 0; line-height: 1; }
            .kpi-badge {
                display: inline-flex;
                align-items: center;
                padding: 5px 12px;
                border-radius: 100px;
                background: rgba(255,255,255,0.18);
                font-size: 11px;
                font-weight: 600;
                width: fit-content;
                backdrop-filter: blur(4px);
            }
            .kpi-earnings  { background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 12px 32px rgba(16,185,129,.35); }
            .kpi-subscriptions { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); box-shadow: 0 12px 32px rgba(99,102,241,.35); }
            .kpi-transactions  { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 12px 32px rgba(245,158,11,.35); }

            /* ---- Stat Cards ---- */
            .stat-card {
                border-radius: 18px;
                padding: 22px 20px;
                display: flex;
                align-items: center;
                gap: 16px;
                position: relative;
                overflow: hidden;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
                cursor: default;
            }
            .stat-card:hover { transform: translateY(-5px); }
            .stat-wave {
                position: absolute;
                bottom: -20px;
                right: -20px;
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background: rgba(255,255,255,0.1);
                pointer-events: none;
            }
            .stat-wave::after {
                content: '';
                position: absolute;
                top: 15px;
                left: 15px;
                right: 15px;
                bottom: 15px;
                border-radius: 50%;
                background: rgba(255,255,255,0.08);
            }
            .stat-icon {
                width: 52px;
                height: 52px;
                border-radius: 14px;
                background: rgba(255,255,255,0.22);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                color: #fff;
                flex-shrink: 0;
            }
            .stat-body { flex: 1; }
            .stat-number {
                font-size: 30px;
                font-weight: 800;
                color: #fff;
                line-height: 1;
                margin-bottom: 4px;
                display: block;
            }
            .stat-label {
                font-size: 12px;
                font-weight: 600;
                color: rgba(255,255,255,0.82);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Stat color themes */
            .stat-blue   { background: linear-gradient(135deg,#3b82f6,#1d4ed8); box-shadow:0 8px 24px rgba(59,130,246,.35); }
            .stat-violet { background: linear-gradient(135deg,#8b5cf6,#6d28d9); box-shadow:0 8px 24px rgba(139,92,246,.35); }
            .stat-teal   { background: linear-gradient(135deg,#14b8a6,#0d9488); box-shadow:0 8px 24px rgba(20,184,166,.35); }
            .stat-cyan   { background: linear-gradient(135deg,#06b6d4,#0891b2); box-shadow:0 8px 24px rgba(6,182,212,.35); }
            .stat-orange { background: linear-gradient(135deg,#f97316,#ea580c); box-shadow:0 8px 24px rgba(249,115,22,.35); }
            .stat-rose   { background: linear-gradient(135deg,#f43f5e,#e11d48); box-shadow:0 8px 24px rgba(244,63,94,.35); }
            .stat-indigo { background: linear-gradient(135deg,#6366f1,#4338ca); box-shadow:0 8px 24px rgba(99,102,241,.35); }
            .stat-green  { background: linear-gradient(135deg,#22c55e,#16a34a); box-shadow:0 8px 24px rgba(34,197,94,.35); }

            /* ---- Dash Cards (chart / list panels) ---- */
            .dash-card {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 2px 16px rgba(0,0,0,0.07);
                border: 1px solid rgba(0,0,0,0.05);
                overflow: hidden;
            }
            .dash-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 24px 0;
            }
            .dash-card-title {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 15px;
                font-weight: 700;
                color: #1e293b;
            }
            .dash-card-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                flex-shrink: 0;
            }
            .dot-blue   { background: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.2); }
            .dot-violet { background: #8b5cf6; box-shadow: 0 0 0 3px rgba(139,92,246,.2); }
            .dot-orange { background: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.2); }
            .dot-rose   { background: #f43f5e; box-shadow: 0 0 0 3px rgba(244,63,94,.2); }
            .dash-card-link {
                font-size: 13px;
                font-weight: 600;
                color: #6366f1;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 4px;
                transition: gap 0.2s;
            }
            .dash-card-link:hover { gap: 8px; color: #4f46e5; }
            .dash-card-body { padding: 20px 24px 24px; }

            /* ---- Dash List ---- */
            .dash-list { list-style: none; margin: 0; padding: 0; }
            .dash-list-item {
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 14px 20px;
                border-bottom: 1px solid #f1f5f9;
                transition: background 0.15s;
            }
            .dash-list-item:last-child { border-bottom: none; }
            .dash-list-item:hover { background: #f8fafc; }
            .dash-list-avatar {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                overflow: hidden;
                flex-shrink: 0;
                display: block;
            }
            .dash-list-avatar-square { border-radius: 10px; }
            .dash-list-avatar img { width: 100%; height: 100%; object-fit: cover; }
            .dash-list-info { flex: 1; min-width: 0; }
            .dash-list-name {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: #1e293b;
                text-decoration: none;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                margin-bottom: 2px;
            }
            .dash-list-name:hover { color: #6366f1; }
            .dash-list-meta { font-size: 12px; color: #94a3b8; }
            .dash-list-action {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                background: #f1f5f9;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #64748b;
                text-decoration: none;
                font-size: 14px;
                transition: background 0.15s, color 0.15s;
                flex-shrink: 0;
            }
            .dash-list-action:hover { background: #6366f1; color: #fff; }

            /* ---- Counter animation ---- */
            @keyframes fadeSlideUp {
                from { opacity:0; transform:translateY(18px); }
                to   { opacity:1; transform:translateY(0); }
            }
            .stat-card { animation: fadeSlideUp 0.5s ease both; }
            .stat-card:nth-child(1) { animation-delay:.05s }
            .stat-card:nth-child(2) { animation-delay:.10s }
            .stat-card:nth-child(3) { animation-delay:.15s }
            .stat-card:nth-child(4) { animation-delay:.20s }
            .stat-card:nth-child(5) { animation-delay:.25s }
            .stat-card:nth-child(6) { animation-delay:.30s }
            .stat-card:nth-child(7) { animation-delay:.35s }
            .stat-card:nth-child(8) { animation-delay:.40s }
        </style>
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset_with_version('vendor/admin/js/charts.js') }}"></script>
        <script>
            (function () {
                "use strict";
                // Animated counter
                document.querySelectorAll('.counter[data-target]').forEach(function (el) {
                    var target = parseInt(el.getAttribute('data-target')) || 0;
                    if (target === 0) { el.textContent = '0'; return; }
                    var duration = 1200;
                    var start = performance.now();
                    function tick(now) {
                        var elapsed = now - start;
                        var progress = Math.min(elapsed / duration, 1);
                        var ease = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.round(ease * target).toLocaleString();
                        if (progress < 1) requestAnimationFrame(tick);
                    }
                    requestAnimationFrame(tick);
                });
            })();
        </script>
    @endpush
@endsection
