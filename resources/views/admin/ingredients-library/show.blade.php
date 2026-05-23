@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Ingredient Library'))
@section('title', d_trans('Ingredient Library'))
@section('header_title', $ingredient->name)
@section('back', route('admin.ingredients-library.index'))
@section('content')

    {{-- Action Bar --}}
    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('admin.ingredients-library.edit', $ingredient->id) }}" class="ing-btn-primary">
            <i class="fa-solid fa-pen me-1"></i>{{ d_trans('Edit') }}
        </a>
        <form action="{{ route('admin.ingredients-library.destroy', $ingredient->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button type="submit" class="ing-btn-danger action-confirm">
                <i class="fa-solid fa-trash me-1"></i>{{ d_trans('Delete') }}
            </button>
        </form>
    </div>

    @php
        $severityMap = [
            'avoid'   => ['cls' => 'ing-sev-avoid',   'icon' => 'fa-ban',                  'label' => 'Avoid'],
            'concern' => ['cls' => 'ing-sev-concern', 'icon' => 'fa-triangle-exclamation', 'label' => 'Concern'],
            'caution' => ['cls' => 'ing-sev-caution', 'icon' => 'fa-circle-exclamation',   'label' => 'Caution'],
            'none'    => ['cls' => 'ing-sev-none',    'icon' => 'fa-circle-check',         'label' => 'None'],
        ];
        $sev = $severityMap[$ingredient->severity ?? 'none'] ?? $severityMap['none'];
    @endphp

    <div class="row g-4">

        {{-- ═══════════════════════════════════════
             LEFT — Main Content
        ═══════════════════════════════════════ --}}
        <div class="col-12 col-lg-8">

            {{-- Identity --}}
            <div class="ing-card mb-4">
                <div class="ing-card-header">
                    <i class="fa-solid fa-flask me-2"></i>{{ d_trans('Identity') }}
                </div>
                <div class="ing-card-body">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 ing-field">
                            <div class="ing-fk">{{ d_trans('Name') }}</div>
                            <div class="ing-fv">{{ $ingredient->name }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field">
                            <div class="ing-fk">{{ d_trans('INCI Name') }}</div>
                            <div class="ing-fv">{{ $ingredient->inci_name ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field">
                            <div class="ing-fk">{{ d_trans('CAS Number') }}</div>
                            <div class="ing-fv ing-mono">{{ $ingredient->cas_number ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field">
                            <div class="ing-fk">{{ d_trans('Regulatory Status') }}</div>
                            <div class="ing-fv">{{ $ingredient->regulatory_status ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field">
                            <div class="ing-fk">{{ d_trans('Source') }}</div>
                            <div class="ing-fv">{{ $ingredient->source ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field">
                            <div class="ing-fk">{{ d_trans('Slug') }}</div>
                            <div class="ing-fv ing-mono">{{ $ingredient->slug ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field ing-field-last">
                            <div class="ing-fk">{{ d_trans('Found in Products') }}</div>
                            <div class="ing-fv">
                                <span class="ing-badge ing-badge-blue">{{ $ingredient->found_in_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if ($ingredient->description)
                <div class="ing-card mb-4">
                    <div class="ing-card-header">
                        <i class="fa-solid fa-align-left me-2"></i>{{ d_trans('Description') }}
                    </div>
                    <div class="ing-card-body">
                        <p class="ing-text">{{ $ingredient->description }}</p>
                    </div>
                </div>
            @endif

            {{-- Safety Information --}}
            <div class="ing-card mb-4">
                <div class="ing-card-header">
                    <i class="fa-solid fa-shield-halved me-2"></i>{{ d_trans('Safety Information') }}
                </div>
                <div class="ing-card-body">
                    <div class="ing-section">
                        <div class="ing-section-label">{{ d_trans('Concern Description') }}</div>
                        @if ($ingredient->concern_description)
                            <p class="ing-text">{{ $ingredient->concern_description }}</p>
                        @else
                            <p class="ing-text-empty">{{ d_trans('No concern description provided.') }}</p>
                        @endif
                    </div>
                    <div class="ing-section" style="border-bottom:none;padding-bottom:0">
                        <div class="ing-section-label">{{ d_trans('Health Effects') }}</div>
                        @if ($ingredient->health_effects)
                            <p class="ing-text">{{ $ingredient->health_effects }}</p>
                        @else
                            <p class="ing-text-empty">{{ d_trans('No health effects provided.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Concerns --}}
            @if (!empty($ingredient->concerns))
                <div class="ing-card mb-4">
                    <div class="ing-card-header">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        {{ d_trans('Concerns') }}
                        <span class="ing-badge ing-badge-blue ms-2">{{ count($ingredient->concerns) }}</span>
                    </div>
                    <div class="ing-card-body p-0">
                        <div class="table-responsive">
                            <table class="ing-table">
                                <thead>
                                    <tr>
                                        <th>{{ d_trans('Category') }}</th>
                                        <th>{{ d_trans('Concern') }}</th>
                                        <th>{{ d_trans('Reference Org') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ingredient->concerns as $concern)
                                        <tr>
                                            <td>
                                                @if (!empty($concern['category']))
                                                    <span class="ing-badge ing-badge-orange">{{ $concern['category'] }}</span>
                                                @else
                                                    <span class="ing-text-empty">—</span>
                                                @endif
                                            </td>
                                            <td class="ing-text">{{ $concern['concern_text'] ?? '—' }}</td>
                                            <td class="ing-mono" style="font-size:0.8rem">{{ $concern['reference_org'] ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Concern Flags --}}
            @if (!empty($ingredient->concern_flags))
                <div class="ing-card mb-4">
                    <div class="ing-card-header">
                        <i class="fa-solid fa-flag me-2"></i>{{ d_trans('Concern Flags') }}
                    </div>
                    <div class="ing-card-body">
                        <div class="ing-flags-grid">
                            @foreach ($ingredient->concern_flags as $flagName => $flagLevel)
                                @php
                                    $lvl = strtolower($flagLevel ?? '');
                                    $flagCls = match(true) {
                                        str_contains($lvl, 'high')   => 'ing-flag-high',
                                        str_contains($lvl, 'medium') => 'ing-flag-medium',
                                        str_contains($lvl, 'mod')    => 'ing-flag-medium',
                                        str_contains($lvl, 'low')    => 'ing-flag-low',
                                        default                      => 'ing-flag-default',
                                    };
                                @endphp
                                <div class="ing-flag-item {{ $flagCls }}">
                                    <span class="ing-flag-name">{{ $flagName }}</span>
                                    <span class="ing-flag-level">{{ $flagLevel }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Functions & Synonyms --}}
            @if (!empty($ingredient->functions) || !empty($ingredient->synonyms))
                <div class="ing-card">
                    <div class="ing-card-header">
                        <i class="fa-solid fa-tags me-2"></i>{{ d_trans('Functions & Synonyms') }}
                    </div>
                    <div class="ing-card-body">
                        @if (!empty($ingredient->functions))
                            <div class="ing-section">
                                <div class="ing-section-label">{{ d_trans('Functions') }}</div>
                                <div class="ing-pill-group">
                                    @foreach ($ingredient->functions as $fn)
                                        <span class="ing-pill ing-pill-blue">{{ $fn }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if (!empty($ingredient->synonyms))
                            <div class="ing-section" style="border-bottom:none;padding-bottom:0">
                                <div class="ing-section-label">{{ d_trans('Synonyms / Aliases') }}</div>
                                <div class="ing-pill-group">
                                    @foreach ($ingredient->synonyms as $syn)
                                        <span class="ing-pill ing-pill-gray">{{ $syn }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        {{-- ═══════════════════════════════════════
             RIGHT — Sidebar
        ═══════════════════════════════════════ --}}
        <div class="col-12 col-lg-4">

            {{-- Image --}}
            @if ($ingredient->image_url)
                <div class="ing-card mb-4">
                    <div class="ing-card-header">
                        <i class="fa-solid fa-image me-2"></i>{{ d_trans('Image') }}
                    </div>
                    <div class="ing-card-body p-0">
                        <img src="{{ asset($ingredient->image_url) }}"
                             alt="{{ $ingredient->name }}"
                             class="ing-img-full">
                    </div>
                </div>
            @endif

            {{-- Severity --}}
            <div class="ing-card mb-4">
                <div class="ing-card-header">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ d_trans('Severity') }}
                </div>
                <div class="ing-card-body d-flex align-items-center justify-content-center py-4">
                    <div class="ing-sev-display {{ $sev['cls'] }}">
                        <i class="fa-solid {{ $sev['icon'] }} ing-sev-icon"></i>
                        <span class="ing-sev-text">{{ d_trans($sev['label']) }}</span>
                    </div>
                </div>
            </div>

            {{-- Hazard Score --}}
            @if (!is_null($ingredient->hazard_score))
                <div class="ing-card mb-4">
                    <div class="ing-card-header">
                        <i class="fa-solid fa-radiation me-2"></i>{{ d_trans('Hazard Score') }}
                    </div>
                    <div class="ing-card-body">
                        @php
                            $score = $ingredient->hazard_score;
                            $pct   = ($score / 10) * 100;
                            $barCls = $score >= 7 ? 'ing-bar-high' : ($score >= 4 ? 'ing-bar-medium' : 'ing-bar-low');
                        @endphp
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="ing-score-num">{{ $score }}</span>
                            <span class="ing-fk">/ 10</span>
                        </div>
                        <div class="ing-bar-track">
                            <div class="ing-bar-fill {{ $barCls }}" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Flags --}}
            <div class="ing-card mb-4">
                <div class="ing-card-header">
                    <i class="fa-solid fa-shield-check me-2"></i>{{ d_trans('Flags') }}
                </div>
                <div class="ing-card-body">
                    <div class="ing-toggle-row">
                        <div>
                            <div class="ing-fv">{{ d_trans('OKO Verified') }}</div>
                            <div class="ing-fk mt-1">{{ d_trans('Reviewed by OKO') }}</div>
                        </div>
                        <span class="ing-bool {{ $ingredient->oko_verified ? 'ing-bool-on' : 'ing-bool-off' }}">
                            {{ $ingredient->oko_verified ? d_trans('Yes') : d_trans('No') }}
                        </span>
                    </div>
                    <div class="ing-toggle-row" style="border-bottom:none;padding-bottom:0">
                        <div>
                            <div class="ing-fv">{{ d_trans('Inhalation Risk') }}</div>
                            <div class="ing-fk mt-1">{{ d_trans('Risk when aerosolized') }}</div>
                        </div>
                        <span class="ing-bool {{ $ingredient->inhalation_risk_flag ? 'ing-bool-danger' : 'ing-bool-off' }}">
                            {{ $ingredient->inhalation_risk_flag ? d_trans('Yes') : d_trans('No') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Visibility --}}
            <div class="ing-card mb-4">
                <div class="ing-card-header">
                    <i class="fa-solid fa-globe me-2"></i>{{ d_trans('Visibility') }}
                </div>
                <div class="ing-card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @if ($ingredient->is_published)
                                <span class="ing-badge ing-badge-green">{{ d_trans('Published') }}</span>
                            @else
                                <span class="ing-badge ing-badge-gray">{{ d_trans('Draft') }}</span>
                            @endif
                            <div class="ing-fk mt-1">
                                {{ $ingredient->is_published ? d_trans('Visible to users') : d_trans('Not visible to users') }}
                            </div>
                        </div>
                        <a href="{{ route('admin.ingredients-library.edit', $ingredient->id) }}" class="ing-icon-btn">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Meta --}}
            <div class="ing-card">
                <div class="ing-card-header">
                    <i class="fa-solid fa-circle-info me-2"></i>{{ d_trans('Meta') }}
                </div>
                <div class="ing-card-body">
                    <div class="ing-meta-row">
                        <span class="ing-fk">{{ d_trans('ID') }}</span>
                        <span class="ing-fv ing-mono">#{{ $ingredient->id }}</span>
                    </div>
                    <div class="ing-meta-row">
                        <span class="ing-fk">{{ d_trans('Created') }}</span>
                        <span class="ing-fv">{{ $ingredient->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="ing-meta-row" style="border-bottom:none;padding-bottom:0">
                        <span class="ing-fk">{{ d_trans('Updated') }}</span>
                        <span class="ing-fv">{{ $ingredient->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --ing-red: #dc2626; --ing-red-dark: #b91c1c;
                --ing-red-soft: rgba(220,38,38,0.08);
                --ing-bg: rgb(249,250,251);
                --ing-border: rgba(0,0,0,0.09);
                --ing-text: #1e293b; --ing-muted: #64748b;
            }

            /* ── Buttons ── */
            .ing-btn-primary {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 9px 20px; background: var(--ing-red); color: #fff;
                border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 500;
                cursor: pointer; text-decoration: none; transition: background .18s;
            }
            .ing-btn-primary:hover { background: var(--ing-red-dark); color: #fff; }
            .ing-btn-danger {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 9px 20px; background: #fee2e2; color: var(--ing-red);
                border: 1px solid #fca5a5; border-radius: 8px; font-size: 0.875rem; font-weight: 500;
                cursor: pointer; transition: background .18s;
            }
            .ing-btn-danger:hover { background: #fecaca; }

            /* ── Cards ── */
            .ing-card { background: #fff; border: 1px solid var(--ing-border); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
            .ing-card-header { padding: 13px 20px; border-bottom: 1px solid var(--ing-border); background: var(--ing-bg); font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ing-muted); display: flex; align-items: center; }
            .ing-card-body { padding: 20px; }

            /* ── Field rows ── */
            .ing-field { padding: 13px 0; border-bottom: 1px solid var(--ing-border); }
            .ing-field:last-child, .ing-field.ing-field-last { border-bottom: none; }
            .ing-fk { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ing-muted); margin-bottom: 3px; }
            .ing-fv { font-size: 0.9rem; font-weight: 500; color: var(--ing-text); }
            .ing-mono { font-family: 'SFMono-Regular', Consolas, monospace; font-size: 0.85rem; }

            /* ── Text sections ── */
            .ing-section { padding: 14px 0; border-bottom: 1px solid var(--ing-border); }
            .ing-section-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ing-muted); margin-bottom: 8px; }
            .ing-text { font-size: 0.875rem; color: var(--ing-text); line-height: 1.65; margin: 0; }
            .ing-text-empty { font-size: 0.875rem; color: var(--ing-muted); font-style: italic; margin: 0; }

            /* ── Table ── */
            .ing-table { width: 100%; border-collapse: collapse; font-size: 0.865rem; }
            .ing-table thead tr { background: var(--ing-bg); }
            .ing-table th { padding: 10px 16px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ing-muted); border-bottom: 1px solid var(--ing-border); text-align: left; }
            .ing-table td { padding: 12px 16px; border-bottom: 1px solid var(--ing-border); color: var(--ing-text); vertical-align: top; }
            .ing-table tbody tr:last-child td { border-bottom: none; }
            .ing-table tbody tr:hover { background: var(--ing-bg); }

            /* ── Concern Flags ── */
            .ing-flags-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px; }
            .ing-flag-item { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 12px 10px; border-radius: 10px; border: 1px solid transparent; text-align: center; }
            .ing-flag-name  { font-size: 0.78rem; font-weight: 700; }
            .ing-flag-level { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
            .ing-flag-high    { background: rgba(220,38,38,0.08);   border-color: rgba(220,38,38,0.2);   color: #dc2626; }
            .ing-flag-medium  { background: rgba(234,88,12,0.08);   border-color: rgba(234,88,12,0.2);   color: #ea580c; }
            .ing-flag-low     { background: rgba(22,163,74,0.08);   border-color: rgba(22,163,74,0.2);   color: #16a34a; }
            .ing-flag-default { background: rgba(100,116,139,0.08); border-color: rgba(100,116,139,0.2); color: #64748b; }

            /* ── Pills ── */
            .ing-pill-group { display: flex; flex-wrap: wrap; gap: 6px; }
            .ing-pill { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 500; }
            .ing-pill-blue { background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.15); }
            .ing-pill-gray { background: var(--ing-bg); color: var(--ing-muted); border: 1px solid var(--ing-border); }

            /* ── Badges ── */
            .ing-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.3px; }
            .ing-badge-green  { background: rgba(22,163,74,0.1);   color: #15803d; }
            .ing-badge-gray   { background: rgba(100,116,139,0.1); color: #64748b; }
            .ing-badge-blue   { background: rgba(37,99,235,0.08);  color: #2563eb; border: 1px solid rgba(37,99,235,0.15); }
            .ing-badge-orange { background: rgba(234,88,12,0.1);   color: #c2410c; }

            /* ── Severity display ── */
            .ing-sev-display { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 20px 32px; border-radius: 16px; border: 2px solid transparent; }
            .ing-sev-icon { font-size: 2rem; }
            .ing-sev-text { font-size: 0.88rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; }
            .ing-sev-none    { background: rgba(100,116,139,0.08); border-color: rgba(100,116,139,0.25); color: #64748b; }
            .ing-sev-caution { background: rgba(202,138,4,0.08);   border-color: rgba(202,138,4,0.25);   color: #a16207; }
            .ing-sev-concern { background: rgba(234,88,12,0.08);   border-color: rgba(234,88,12,0.25);   color: #ea580c; }
            .ing-sev-avoid   { background: rgba(220,38,38,0.08);   border-color: rgba(220,38,38,0.25);   color: #dc2626; }

            /* ── Hazard score bar ── */
            .ing-score-num { font-size: 2rem; font-weight: 800; color: var(--ing-text); line-height: 1; }
            .ing-bar-track { height: 8px; background: var(--ing-bg); border-radius: 99px; overflow: hidden; border: 1px solid var(--ing-border); }
            .ing-bar-fill  { height: 100%; border-radius: 99px; transition: width .4s ease; }
            .ing-bar-low    { background: #16a34a; }
            .ing-bar-medium { background: #ea580c; }
            .ing-bar-high   { background: #dc2626; }

            /* ── Boolean flags ── */
            .ing-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--ing-border); }
            .ing-bool { padding: 3px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.3px; }
            .ing-bool-on     { background: rgba(22,163,74,0.1);   color: #15803d; }
            .ing-bool-off    { background: rgba(100,116,139,0.1); color: #64748b; }
            .ing-bool-danger { background: rgba(220,38,38,0.1);   color: #dc2626; }

            /* ── Meta rows ── */
            .ing-meta-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--ing-border); }

            /* ── Icon button ── */
            .ing-icon-btn { width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--ing-border); background: transparent; color: var(--ing-muted); display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all .18s; }
            .ing-icon-btn:hover { background: var(--ing-red-soft); color: var(--ing-red); border-color: rgba(220,38,38,0.2); }

            /* ── Image ── */
            .ing-img-full { display: block; width: 100%; max-height: 220px; object-fit: contain; background: var(--ing-bg); }
        </style>
    @endpush

@endsection
