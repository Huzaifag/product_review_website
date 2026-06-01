@push('styles')
    <style>
        :root {
            --member-red: #dc2626;
            --member-red-dark: #b91c1c;
            --member-red-soft: rgba(220, 38, 38, 0.08);
            --member-bg: rgb(249, 250, 251);
            --member-border: rgba(0, 0, 0, 0.08);
            --member-text: #1e293b;
            --member-muted: #64748b;
        }

        .split-stat-card,
        .vironeer-counter-card {
            background: #fff !important;
            border: 1px solid var(--member-border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 100px;
            color: var(--member-text) !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .split-stat-card:hover,
        .vironeer-counter-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .split-card-content,
        .vironeer-counter-card-meta {
            position: static;
            z-index: 1;
            flex: 1;
        }

        .split-card-title,
        .vironeer-counter-card-title {
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            color: rgba(220, 38, 38, 0.55) !important;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0 0 4px !important;
            opacity: 1 !important;
            text-shadow: none !important;
        }

        .split-card-number,
        .vironeer-counter-card-number {
            font-size: 1.75rem !important;
            font-weight: 700 !important;
            color: var(--member-text) !important;
            margin: 0 !important;
            line-height: 1;
            text-shadow: none !important;
        }

        .split-card-icon,
        .vironeer-counter-card-icon {
            position: static !important;
            width: 48px !important;
            height: 48px !important;
            min-width: 48px;
            border-radius: 12px !important;
            background: var(--member-red-soft) !important;
            color: var(--member-red) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem !important;
        }

        .card,
        .settings-card {
            background: #fff;
            border: 1px solid var(--member-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .card-header,
        .settings-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--member-border) !important;
            background: var(--member-bg);
        }

        .settings-card-title {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--member-text);
        }

        .settings-card-body {
            padding: 24px;
        }

        .form-label {
            margin-bottom: 8px;
            color: var(--member-text);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .form-control,
        .form-select,
        .bootstrap-select > .dropdown-toggle {
            min-height: 42px;
            border: 1px solid var(--member-border) !important;
            border-radius: 8px !important;
            background: #fff !important;
            color: var(--member-text) !important;
            font-size: 0.875rem;
            outline: none;
            box-shadow: none !important;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .form-control {
            padding: 9px 14px;
        }

        .form-control:focus,
        .form-select:focus,
        .bootstrap-select > .dropdown-toggle:focus {
            border-color: var(--member-red) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 40px;
            padding: 9px 20px;
            background: var(--member-red) !important;
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
            background: var(--member-red-dark) !important;
            color: #fff !important;
        }

        .btn-soft,
        .btn-outline-secondary,
        .btn-outline-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 40px;
            padding: 9px 16px;
            background: transparent !important;
            color: var(--member-muted) !important;
            border: 1px solid var(--member-border) !important;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s, color 0.18s, border-color 0.18s;
            white-space: nowrap;
        }

        .btn-soft:hover,
        .btn-outline-secondary:hover,
        .btn-outline-primary:hover {
            background: var(--member-red-soft) !important;
            color: var(--member-red) !important;
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
            border-bottom: 1px solid var(--member-border);
            white-space: nowrap;
            background: var(--member-bg);
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
            color: var(--member-text);
            vertical-align: middle;
        }

        .table a {
            color: var(--member-red);
            text-decoration: none;
        }

        .item-img.item-img-sm,
        .attach-img-preview {
            border-radius: 10px !important;
            border: 1px solid var(--member-border) !important;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
        }

        .item-title {
            color: var(--member-text) !important;
            font-weight: 600 !important;
        }

        .item-title:hover {
            color: var(--member-red) !important;
        }

        .item-text {
            color: var(--member-muted) !important;
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

        .bg-success,
        .bg-c19,
        .bg-c9 {
            background: rgba(22, 163, 74, 0.1) !important;
            color: #15803d !important;
        }

        .bg-danger,
        .bg-c20,
        .bg-c6 {
            background: rgba(220, 38, 38, 0.1) !important;
            color: #dc2626 !important;
        }

        .dropdown-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--member-border);
            background: transparent;
            color: var(--member-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }

        .dropdown-btn:hover {
            background: var(--member-red-soft);
            color: var(--member-red);
            border-color: rgba(220, 38, 38, 0.2);
        }

        .settings-box.v2 {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            gap: 24px;
            align-items: start;
        }

        .settings-side {
            background: #fff;
            border: 1px solid var(--member-border);
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .settings-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            min-height: 42px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--member-text);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
        }

        .settings-link:hover,
        .settings-link.active {
            background: var(--member-red-soft);
            color: var(--member-red);
        }

        .settings-content {
            min-width: 0;
        }

        .input-group .form-control {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .input-group .btn {
            border-radius: 0 !important;
        }

        .input-group .btn:last-child {
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
        }

        @media (max-width: 991px) {
            .settings-box.v2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575px) {
            .card-header,
            .settings-card-header,
            .settings-card-body {
                padding: 16px;
            }

            .table td,
            .table thead th {
                padding: 12px;
            }
        }
    </style>
@endpush
