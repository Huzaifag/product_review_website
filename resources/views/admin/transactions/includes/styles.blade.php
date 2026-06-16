@push('styles')
    <style>
        :root {
            --trx-red: #dc2626;
            --trx-red-dark: #b91c1c;
            --trx-red-soft: rgba(220, 38, 38, 0.08);
            --trx-bg: rgb(249, 250, 251);
            --trx-border: rgba(0, 0, 0, 0.08);
            --trx-text: #1e293b;
            --trx-muted: #64748b;
        }

        .split-stat-card {
            background: #fff !important;
            border: 1px solid var(--trx-border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 100px;
            color: var(--trx-text) !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .split-stat-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .split-card-content {
            position: static;
            z-index: 1;
            flex: 1;
        }

        .split-card-title {
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            color: rgba(220, 38, 38, 0.55) !important;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0 0 4px !important;
            opacity: 1 !important;
            text-shadow: none !important;
        }

        .split-card-number {
            font-size: 1.75rem !important;
            font-weight: 700 !important;
            color: var(--trx-text) !important;
            margin: 0 !important;
            line-height: 1;
            text-shadow: none !important;
        }

        .split-card-icon {
            position: static !important;
            width: 48px !important;
            height: 48px !important;
            min-width: 48px;
            border-radius: 12px !important;
            background: var(--trx-red-soft) !important;
            color: var(--trx-red) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem !important;
        }

        .card {
            background: #fff;
            border: 1px solid var(--trx-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--trx-border) !important;
            background: var(--trx-bg);
        }

        .trx-search-wrap {
            position: relative;
        }

        .trx-search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--trx-muted);
            font-size: 0.8rem;
            pointer-events: none;
        }

        .trx-search-input,
        .form-control,
        .bootstrap-select > .dropdown-toggle {
            min-height: 42px;
            border: 1px solid var(--trx-border) !important;
            border-radius: 8px !important;
            background: #fff !important;
            color: var(--trx-text) !important;
            font-size: 0.875rem;
            outline: none;
            box-shadow: none !important;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .trx-search-input,
        .form-control {
            width: 100%;
            padding: 9px 14px;
        }

        .trx-search-input {
            padding-left: 38px;
        }

        .trx-search-input:focus,
        .form-control:focus,
        .bootstrap-select > .dropdown-toggle:focus {
            border-color: var(--trx-red) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 40px;
            padding: 9px 20px;
            background: var(--trx-red) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s;
            white-space: nowrap;
        }

        .btn-primary:hover {
            background: var(--trx-red-dark) !important;
            color: #fff !important;
        }

        .btn-soft,
        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 40px;
            padding: 9px 16px;
            background: transparent !important;
            color: var(--trx-muted) !important;
            border: 1px solid var(--trx-border) !important;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s, color 0.18s, border-color 0.18s;
            white-space: nowrap;
        }

        .btn-soft:hover,
        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-danger:hover {
            background: var(--trx-red-soft) !important;
            color: var(--trx-red) !important;
            border-color: rgba(220, 38, 38, 0.2) !important;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            margin: 0;
        }

        .table thead th {
            padding: 11px 16px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid var(--trx-border);
            white-space: nowrap;
            background: var(--trx-bg);
            color: #64748b;
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            background: #fff;
            transition: background 0.15s;
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(220, 38, 38, 0.035), #ffffff);
        }

        .table td {
            padding: 12px 16px;
            color: var(--trx-text);
            vertical-align: middle;
        }

        .table a,
        .list-group-item a {
            color: var(--trx-text) !important;
            font-weight: 600;
            text-decoration: none;
        }

        .table a:hover,
        .list-group-item a:hover {
            color: var(--trx-red) !important;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .bg-success {
            background: rgba(22, 163, 74, 0.1) !important;
            color: #15803d !important;
        }

        .bg-danger {
            background: rgba(220, 38, 38, 0.1) !important;
            color: #dc2626 !important;
        }

        .bg-warning {
            background: rgba(245, 158, 11, 0.12) !important;
            color: #b45309 !important;
        }

        .dropdown-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--trx-border);
            background: transparent;
            color: var(--trx-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }

        .dropdown-btn:hover {
            background: var(--trx-red-soft);
            color: var(--trx-red);
            border-color: rgba(220, 38, 38, 0.2);
        }

        .list-group-item {
            border-color: var(--trx-border);
            color: var(--trx-text);
        }

        .list-group-item strong {
            color: var(--trx-muted);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        @media (max-width: 575px) {
            .card-header,
            .card-body,
            .list-group-item {
                padding: 16px !important;
            }

            .table td,
            .table thead th {
                padding: 12px;
            }
        }
    </style>
@endpush
