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
            @csrf
            @method('DELETE')
            <button type="submit" class="ing-btn-danger action-confirm">
                <i class="fa-solid fa-trash me-1"></i>{{ d_trans('Delete') }}
            </button>
        </form>
    </div>

    <div class="row g-4">

        {{-- Left: Main Details --}}
        <div class="col-12 col-lg-8">

            {{-- Identity --}}
            <div class="ing-detail-card mb-4">
                <div class="ing-detail-card-header">
                    <i class="fa-solid fa-flask me-2"></i>{{ d_trans('Identity') }}
                </div>
                <div class="ing-detail-card-body">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 ing-field-row">
                            <div class="ing-field-key">{{ d_trans('Name') }}</div>
                            <div class="ing-field-val">{{ $ingredient->name }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field-row">
                            <div class="ing-field-key">{{ d_trans('INCI Name') }}</div>
                            <div class="ing-field-val">{{ $ingredient->inci_name ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field-row">
                            <div class="ing-field-key">{{ d_trans('CAS Number') }}</div>
                            <div class="ing-field-val ing-monospace">{{ $ingredient->cas_number ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field-row">
                            <div class="ing-field-key">{{ d_trans('Regulatory Status') }}</div>
                            <div class="ing-field-val">{{ $ingredient->regulatory_status ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field-row ing-field-row-last">
                            <div class="ing-field-key">{{ d_trans('Slug') }}</div>
                            <div class="ing-field-val ing-monospace">{{ $ingredient->slug ?: '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6 ing-field-row ing-field-row-last">
                            <div class="ing-field-key">{{ d_trans('Found in Products') }}</div>
                            <div class="ing-field-val">
                                <span class="ing-badge ing-badge-count">{{ $ingredient->found_in_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Safety Information --}}
            <div class="ing-detail-card">
                <div class="ing-detail-card-header">
                    <i class="fa-solid fa-shield-halved me-2"></i>{{ d_trans('Safety Information') }}
                </div>
                <div class="ing-detail-card-body">
                    <div class="ing-text-section">
                        <div class="ing-text-label">{{ d_trans('Concern Description') }}</div>
                        @if ($ingredient->concern_description)
                            <p class="ing-text-body">{{ $ingredient->concern_description }}</p>
                        @else
                            <p class="ing-text-empty">{{ d_trans('No concern description provided.') }}</p>
                        @endif
                    </div>
                    <div class="ing-text-section">
                        <div class="ing-text-label">{{ d_trans('Health Effects') }}</div>
                        @if ($ingredient->health_effects)
                            <p class="ing-text-body">{{ $ingredient->health_effects }}</p>
                        @else
                            <p class="ing-text-empty">{{ d_trans('No health effects provided.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: Sidebar --}}
        <div class="col-12 col-lg-4">

            {{-- Severity --}}
            <div class="ing-detail-card mb-4">
                <div class="ing-detail-card-header">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ d_trans('Severity') }}
                </div>
                <div class="ing-detail-card-body d-flex align-items-center justify-content-center py-4">
                    @php
                        $severityMap = [
                            'avoid'   => ['cls' => 'ing-sev-avoid',   'icon' => 'fa-ban',                  'label' => 'Avoid'],
                            'concern' => ['cls' => 'ing-sev-concern', 'icon' => 'fa-triangle-exclamation', 'label' => 'Concern'],
                            'caution' => ['cls' => 'ing-sev-caution', 'icon' => 'fa-circle-exclamation',   'label' => 'Caution'],
                            'none'    => ['cls' => 'ing-sev-none',    'icon' => 'fa-circle-check',         'label' => 'None'],
                        ];
                        $sev = $severityMap[$ingredient->severity ?? 'none'] ?? $severityMap['none'];
                    @endphp
                    <div class="ing-severity-display {{ $sev['cls'] }}">
                        <i class="fa-solid {{ $sev['icon'] }} ing-severity-icon"></i>
                        <span class="ing-severity-text">{{ d_trans($sev['label']) }}</span>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="ing-detail-card mb-4">
                <div class="ing-detail-card-header">
                    <i class="fa-solid fa-globe me-2"></i>{{ d_trans('Visibility') }}
                </div>
                <div class="ing-detail-card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="ing-field-val">
                                @if ($ingredient->is_published)
                                    <span class="ing-badge ing-badge-published">{{ d_trans('Published') }}</span>
                                @else
                                    <span class="ing-badge ing-badge-draft">{{ d_trans('Draft') }}</span>
                                @endif
                            </div>
                            <div class="ing-field-key mt-1">
                                {{ $ingredient->is_published ? d_trans('Visible to users') : d_trans('Not visible to users') }}
                            </div>
                        </div>
                        <a href="{{ route('admin.ingredients-library.edit', $ingredient->id) }}"
                            class="ing-edit-link">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Meta --}}
            <div class="ing-detail-card">
                <div class="ing-detail-card-header">
                    <i class="fa-solid fa-circle-info me-2"></i>{{ d_trans('Meta') }}
                </div>
                <div class="ing-detail-card-body">
                    <div class="ing-meta-row">
                        <span class="ing-field-key">{{ d_trans('Created') }}</span>
                        <span class="ing-field-val">{{ $ingredient->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="ing-meta-row">
                        <span class="ing-field-key">{{ d_trans('Updated') }}</span>
                        <span class="ing-field-val">{{ $ingredient->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="ing-meta-row">
                        <span class="ing-field-key">{{ d_trans('ID') }}</span>
                        <span class="ing-field-val ing-monospace">#{{ $ingredient->id }}</span>
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
                --ing-border: rgba(0,0,0,0.08);
                --ing-text: #1e293b; --ing-muted: #64748b;
            }

            /* Buttons */
            .ing-btn-primary {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 9px 20px; background: var(--ing-red); color: #fff;
                border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 500;
                cursor: pointer; text-decoration: none; transition: background 0.18s;
            }
            .ing-btn-primary:hover { background: var(--ing-red-dark); color: #fff; }
            .ing-btn-danger {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 9px 20px; background: #fee2e2; color: var(--ing-red);
                border: 1px solid #fca5a5; border-radius: 8px; font-size: 0.875rem; font-weight: 500;
                cursor: pointer; transition: background 0.18s;
            }
            .ing-btn-danger:hover { background: #fecaca; }

            /* Detail Cards */
            .ing-detail-card { background: #fff; border: 1px solid var(--ing-border); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
            .ing-detail-card-header { padding: 14px 20px; border-bottom: 1px solid var(--ing-border); background: var(--ing-bg); font-size: 0.82rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ing-muted); }
            .ing-detail-card-body { padding: 20px; }

            /* Field rows */
            .ing-field-row { padding: 14px 0; border-bottom: 1px solid var(--ing-border); }
            .ing-field-row.ing-field-row-last:last-child { border-bottom: none; }
            .ing-field-key { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ing-muted); margin-bottom: 4px; }
            .ing-field-val { font-size: 0.9rem; font-weight: 500; color: var(--ing-text); }
            .ing-monospace { font-family: 'SFMono-Regular', Consolas, monospace; font-size: 0.85rem; }

            /* Text sections */
            .ing-text-section { padding: 16px 0; border-bottom: 1px solid var(--ing-border); }
            .ing-text-section:last-child { border-bottom: none; padding-bottom: 0; }
            .ing-text-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ing-muted); margin-bottom: 8px; }
            .ing-text-body  { font-size: 0.875rem; color: var(--ing-text); line-height: 1.6; margin: 0; }
            .ing-text-empty { font-size: 0.875rem; color: var(--ing-muted); font-style: italic; margin: 0; }

            /* Meta rows */
            .ing-meta-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--ing-border); }
            .ing-meta-row:last-child { border-bottom: none; padding-bottom: 0; }

            /* Severity Display */
            .ing-severity-display {
                display: flex; flex-direction: column; align-items: center; gap: 8px;
                padding: 20px 32px; border-radius: 16px; border: 2px solid transparent;
            }
            .ing-severity-icon { font-size: 2rem; }
            .ing-severity-text { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; }

            .ing-sev-none    { background: rgba(100,116,139,0.08); border-color: rgba(100,116,139,0.3); color: #64748b; }
            .ing-sev-caution { background: rgba(202,138,4,0.08);   border-color: rgba(202,138,4,0.3);   color: #a16207; }
            .ing-sev-concern { background: rgba(234,88,12,0.08);   border-color: rgba(234,88,12,0.3);   color: #ea580c; }
            .ing-sev-avoid   { background: rgba(220,38,38,0.08);   border-color: rgba(220,38,38,0.3);   color: #dc2626; }

            /* Badges */
            .ing-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.3px; }
            .ing-badge-published { background: rgba(22,163,74,0.1);  color: #15803d; }
            .ing-badge-draft     { background: rgba(100,116,139,0.1); color: #64748b; }
            .ing-badge-count     { background: rgba(37,99,235,0.08);  color: #2563eb; border: 1px solid rgba(37,99,235,0.15); }

            /* Edit link */
            .ing-edit-link {
                width: 34px; height: 34px; border-radius: 8px;
                border: 1px solid var(--ing-border); background: transparent; color: var(--ing-muted);
                display: inline-flex; align-items: center; justify-content: center;
                text-decoration: none; transition: all 0.18s;
            }
            .ing-edit-link:hover { background: var(--ing-red-soft); color: var(--ing-red); border-color: rgba(220,38,38,0.2); }
        </style>
    @endpush

@endsection
