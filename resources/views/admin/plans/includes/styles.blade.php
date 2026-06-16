@push('styles')
    <style>
        :root {
            --plan-red: #dc2626;
            --plan-red-dark: #b91c1c;
            --plan-red-soft: rgba(220, 38, 38, 0.08);
            --plan-bg: rgb(249, 250, 251);
            --plan-border: rgba(0, 0, 0, 0.08);
            --plan-text: #1e293b;
            --plan-muted: #64748b;
        }

        .card {
            background: #fff;
            border: 1px solid var(--plan-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--plan-border) !important;
            background: var(--plan-bg);
            color: var(--plan-text);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .card-body {
            background: #fff;
        }

        .plan-search-wrap {
            position: relative;
        }

        .plan-search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--plan-muted);
            font-size: 0.8rem;
            pointer-events: none;
        }

        .plan-search-input,
        .form-control,
        .form-select {
            min-height: 42px;
            border: 1px solid var(--plan-border) !important;
            border-radius: 8px !important;
            background: #fff !important;
            color: var(--plan-text) !important;
            font-size: 0.875rem;
            outline: none;
            box-shadow: none !important;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .plan-search-input,
        .form-control {
            width: 100%;
            padding: 9px 14px;
        }

        .plan-search-input {
            padding-left: 38px;
        }

        .plan-search-input:focus,
        .form-control:focus,
        .form-select:focus {
            border-color: var(--plan-red) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        .form-label {
            margin-bottom: 8px;
            color: var(--plan-text);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .form-text {
            color: var(--plan-muted);
            font-size: 0.78rem;
        }

        .input-group-text {
            border-color: var(--plan-border);
            background: var(--plan-bg);
            color: var(--plan-muted);
            font-size: 0.875rem;
            font-weight: 700;
        }

        .input-group .form-control {
            border-radius: 0 !important;
        }

        .input-group .input-group-text:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .input-group .input-group-text:last-child,
        .input-group .btn:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 40px;
            padding: 9px 20px;
            background: var(--plan-red) !important;
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
            background: var(--plan-red-dark) !important;
            color: #fff !important;
        }

        .btn-soft,
        .btn-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 40px;
            padding: 9px 16px;
            background: transparent !important;
            color: var(--plan-muted) !important;
            border: 1px solid var(--plan-border) !important;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s, color 0.18s, border-color 0.18s;
            white-space: nowrap;
        }

        .btn-soft:hover,
        .btn-dark:hover {
            background: var(--plan-red-soft) !important;
            color: var(--plan-red) !important;
            border-color: rgba(220, 38, 38, 0.2) !important;
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            border: 1px solid rgba(220, 38, 38, 0.2) !important;
            border-radius: 8px;
            background: rgba(220, 38, 38, 0.08) !important;
            color: var(--plan-red) !important;
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
            border-bottom: 1px solid var(--plan-border);
            white-space: nowrap;
            background: var(--plan-bg);
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
            color: var(--plan-text);
            vertical-align: middle;
        }

        .table a {
            color: var(--plan-text) !important;
            font-weight: 600;
            text-decoration: none;
        }

        .table a:hover {
            color: var(--plan-red) !important;
        }

        .sortable-handle {
            color: var(--plan-muted);
            cursor: grab;
            width: 42px;
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

        .bg-primary {
            background: var(--plan-red-soft) !important;
            color: var(--plan-red) !important;
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .dropdown-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--plan-border);
            background: transparent;
            color: var(--plan-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }

        .dropdown-btn:hover {
            background: var(--plan-red-soft);
            color: var(--plan-red);
            border-color: rgba(220, 38, 38, 0.2);
        }

        @media (max-width: 575px) {
            .card-header,
            .card-body {
                padding: 16px !important;
            }

            .table td,
            .table thead th {
                padding: 12px;
            }
        }
    </style>
@endpush
