@extends('themes.basic.layouts.single')
@section('title', $product->name)
@section('header_title', $product->name)
@section('description', $product->description)
@section('keywords', $product->brand_name . ',' . $product->name)
@section('breadcrumbs', Breadcrumbs::render('products.show', $product))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'products.show', $product))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')
    @push('styles')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

            :root {
                --gd: #18281a;
                --gm: #2a3e2c;
                --ta: #f7d9a7;
                --td: #111714;
                --tm: #374035;
                --tl: #6b7566;
                --cr: #f6f1e8;
                --cr2: #ede7d9;
                --bd: #d6d0c4;
                --gg: #15803d;
                --ggb: #dcfce7;
                --gg2: #bbf7d0;
                --gr: #dc2626;
                --grb: #fee2e2;
                --gr2: #fecaca;
                --go: #b45309;
                --gob: #fef3c7;
                --blue-row: #f0f7ff;
                --blue-bd: #bfdbfe;
                --s1: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
                --s2: 0 4px 16px rgba(0, 0, 0, .08), 0 2px 6px rgba(0, 0, 0, .05);
                --s3: 0 12px 40px rgba(0, 0, 0, .12), 0 4px 12px rgba(0, 0, 0, .07);
            }

            *,
            *::before,
            *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            .cmp-shell {
                font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                margin-top: 28px;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: var(--s3), 0 0 0 1px rgba(0, 0, 0, .06);
            }

            /* ── Title bar ── */
            .cmp-titlebar {
                background: var(--gr);
                background-image: radial-gradient(ellipse at 80% 50%, rgba(184, 147, 90, .12) 0%, transparent 60%);
                padding: 18px 26px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                border-bottom: 1px solid rgba(255, 255, 255, .07);
            }

            .cmp-titlebar-left {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .cmp-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                font-size: .66rem;
                letter-spacing: .16em;
                text-transform: uppercase;
                color: var(--ta);
                font-weight: 700;
            }

            .cmp-eyebrow::before {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--ta);
                flex-shrink: 0;
            }

            .cmp-title {
                font-size: 1.3rem;
                font-weight: 800;
                color: #fff;
                letter-spacing: -.02em;
                line-height: 1.2;
            }

            .cmp-sub {
                font-size: .8rem;
                color: rgba(255, 255, 255, .45);
                font-weight: 500;
            }

            .cmp-count-badge {
                background: rgba(255, 255, 255, .1);
                border: 1px solid rgba(255, 255, 255, .15);
                color: rgba(255, 255, 255, .75);
                border-radius: 999px;
                padding: 5px 14px;
                font-size: .76rem;
                font-weight: 600;
                white-space: nowrap;
            }

            /* ── Scroll wrapper ── */
            .cmp-scroll {
                overflow-x: auto;
                background: #fff;
            }

            /* ── Table ── */
            .comp-table {
                width: 100%;
                border-collapse: collapse;
                font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                min-width: 720px;
            }

            .comp-table th,
            .comp-table td {
                padding: 0;
                border: none;
                vertical-align: middle;
                text-align: left;
            }

            /* ── Image row ── */
            .row-images th {
                padding: 20px 16px 16px;
                background: var(--cr2);
                text-align: center;
                vertical-align: bottom;
                border-bottom: 2px solid var(--bd);
                border-right: 1px solid var(--bd);
            }

            .row-images th:first-child {
                text-align: left;
                background: var(--cr);
                border-right: 2px solid var(--bd);
            }

            .row-images th:last-child {
                border-right: none;
            }

            .comp-prod-img {
                height: 100px;
                width: auto;
                max-width: 90px;
                object-fit: contain;
                display: block;
                margin: 0 auto 10px;
                border-radius: 8px;
                filter: drop-shadow(0 2px 6px rgba(0, 0, 0, .1));
            }

            .prod-img-label {
                font-size: .76rem;
                font-weight: 700;
                color: var(--td);
                line-height: 1.3;
                max-width: 110px;
                margin: 0 auto;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .prod-img-label.is-primary {
                color: var(--gm);
            }

            .row-img-corner {
                display: flex;
                flex-direction: column;
                gap: 4px;
                justify-content: flex-end;
                padding-bottom: 2px;
            }

            .row-img-cat {
                font-size: .6rem;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: var(--tl);
                font-weight: 600;
            }


            .row-img-cat-h {
                font-size: 1.4rem;
                /* text-transform: uppercase; */
                letter-spacing: .1em;
                color: var(--gr);
                font-weight: 700;
                line-height: 1.4;
            }

            .row-img-heading {
                font-size: .88rem;
                font-weight: 700;
                color: var(--td);
            }

            /* ── Column header row ── */
            .row-header th {
                background: var(--gd);
                color: #fff;
                font-size: .84rem;
                font-weight: 700;
                padding: 12px 16px;
                border-right: 1px solid rgba(255, 255, 255, .1);
                white-space: nowrap;
            }

            .row-header th:first-child {
                font-size: .76rem;
                font-weight: 600;
                color: rgba(255, 255, 255, .55);
                text-transform: uppercase;
                letter-spacing: .08em;
                border-right: 2px solid rgba(255, 255, 255, .15);
                white-space: normal;
            }

            .row-header th.is-primary {
                background: var(--gm);
            }

            .row-header th:last-child {
                border-right: none;
            }

            /* ── Body rows ── */
            .comp-table tbody tr {
                transition: background .12s;
            }

            .comp-table tbody tr:not(.row-overall):hover td {
                background: #fafaf8 !important;
            }

            .comp-table tbody td {
                padding: 11px 16px;
                font-size: .86rem;
                font-weight: 600;
                color: var(--td);
                border-bottom: 1px solid var(--bd);
                border-right: 1px solid var(--bd);
            }

            .comp-table tbody td:first-child {
                font-weight: 500;
                color: var(--tl);
                font-size: .82rem;
                background: var(--cr);
                border-right: 2px solid var(--bd);
                width: 22%;
            }

            .comp-table tbody td.is-primary {
                background: rgba(42, 62, 44, .04);
            }

            .comp-table tbody td:last-child {
                border-right: none;
            }

            .comp-table tbody tr:last-child td {
                border-bottom: none;
            }

            /* Blue highlight rows */
            .row-blue td {
                background: var(--blue-row) !important;
            }

            .row-blue td:first-child {
                background: #e8f2fb !important;
            }

            .row-blue:hover td {
                background: #e3f0fb !important;
            }

            /* Overall row */
            .row-overall td {
                background: var(--cr2) !important;
                font-weight: 700 !important;
            }

            .row-overall td:first-child {
                background: var(--gd) !important;
                color: var(--cr) !important;
                font-weight: 700 !important;
                border-right-color: rgba(255, 255, 255, .2) !important;
            }

            .row-overall td.is-primary {
                background: rgba(42, 62, 44, .08) !important;
            }

            .row-overall td:not(:first-child):hover {
                background: rgba(42, 62, 44, .12) !important;
            }

            /* Grade chips */
            .grade-chip {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 3px 10px;
                border-radius: 999px;
                font-size: .75rem;
                font-weight: 700;
                letter-spacing: .01em;
            }

            .grade-chip::before {
                content: '';
                width: 5px;
                height: 5px;
                border-radius: 50%;
                background: currentColor;
                opacity: .65;
            }

            .gc-good {
                background: var(--ggb);
                color: var(--gg);
                box-shadow: 0 0 0 1px var(--gg2);
            }

            .gc-poor {
                background: var(--grb);
                color: var(--gr);
                box-shadow: 0 0 0 1px var(--gr2);
            }

            .gc-ok {
                background: var(--gob);
                color: var(--go);
            }

            .gc-na {
                background: #f1f5f9;
                color: #94a3b8;
                font-weight: 500;
            }

            /* Bool chips */
            .bool-y {
                color: var(--gg);
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                gap: 4px;
            }

            .bool-n {
                color: var(--gr);
                font-weight: 700;
                display: inline-flex;
                align-items: center:gap:4px;
            }

            .bool-na {
                color: var(--tl);
                font-weight: 400;
                font-size: .8rem;
            }

            /* Primary col marker */
            .primary-marker {
                display: inline-block;
                background: var(--ta);
                color: #fff;
                font-size: .56rem;
                font-weight: 700;
                letter-spacing: .08em;
                text-transform: uppercase;
                padding: 2px 7px;
                border-radius: 999px;
                margin-bottom: 4px;
            }

            @media (max-width: 640px) {
                .cmp-titlebar {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 10px;
                }
            }
        </style>
    @endpush
    @if ($canSeeDetails)
        @if ($similarProducts->count())
            @php
                $gradeChip = function ($g) {
                    if (!$g) {
                        return '<span class="bool-na">—</span>';
                    }
                    $label = \App\Enums\GradeEnum::getLabel($g);
                    $class = \App\Enums\GradeEnum::getClass($g);
                    return "<span class='grade-chip {$class}'>{$label}</span>";
                };
                $boolCell = function ($v) {
                    return \App\Enums\BooleanEnum::getHtml($v);
                };
                $total = 1 + $similarProducts->count();
            @endphp

            <div class="cmp-shell">

                {{-- Title bar --}}
                <div class="cmp-titlebar">
                    <div class="cmp-titlebar-left">
                        <span class="cmp-eyebrow">{{ d_trans('Side-by-Side Analysis') }}</span>
                        <div class="cmp-title">{{ d_trans('Product Comparison') }}</div>
                        <div class="cmp-sub">{{ $product->category->trans->name ?? '' }} ·
                            {{ d_trans('Lab-tested results') }}
                        </div>
                    </div>
                    <span class="cmp-count-badge">{{ $total }} {{ d_trans('products') }}</span>
                </div>

                {{-- Table --}}
                <div class="cmp-scroll">
                    <table class="comp-table">
                        <thead>

                            {{-- Image row --}}
                            <tr class="row-images">
                                <th>
                                    <div class="row-img-corner">
                                        <div class="row-img-cat-h">{{ $testName ?? d_trans('Product Test') }}
                                        </div>
                                </th>
                                <th>
                                    <img class="comp-prod-img"
                                        src="{{ asset($product->image ?? 'images/placeholder.png') }}"
                                        alt="{{ $product->name }}">
                                    <div class="prod-img-label is-primary">{{ $product->name }}</div>
                                </th>
                                @foreach ($similarProducts as $sim)
                                    <th>
                                        <img class="comp-prod-img"
                                            src="{{ asset($sim->image ?? 'images/placeholder.png') }}"
                                            alt="{{ $sim->name }}">
                                        <div class="prod-img-label">{{ $sim->name }}</div>
                                    </th>
                                @endforeach
                            </tr>

                            {{-- Name/header row --}}
                            <tr class="row-header">
                                <th>{{ d_trans('Attribute') }}</th>
                                <th class="is-primary">{{ $product->name }}</th>
                                @foreach ($similarProducts as $sim)
                                    <th>{{ $sim->name }}</th>
                                @endforeach
                            </tr>

                        </thead>
                        <tbody>

                            <tr>
                                <td>{{ d_trans('Anbieter') }}</td>
                                <td class="is-primary">{{ $product->brand?->name ?? '—' }}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{{ $sim->brand?->name ?? '—' }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td>{{ d_trans('Preis') }}</td>
                                <td class="is-primary">{{ numberFormat($product->price ?? 0) }}
                                    {{ $product->currency ?? 'Euro' }}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{{ numberFormat($sim->price ?? 0) }} {{ $sim->currency ?? 'Euro' }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td>{{ d_trans('Size') }}</td>
                                <td class="is-primary">{{ $product->product_size ?? '—' }}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{{ $sim->product_size ?? '—' }}</td>
                                @endforeach
                            </tr>

                            {{-- Dynamic test attribute rows --}}
                            @foreach ($testAttributes as $attr)
                                @php
                                    // Skip attributes already shown as hardcoded rows or at the bottom
                                    $skipAttributes = [
                                        'brand',
                                        'anbieter',
                                        'provider',
                                        'price',
                                        'preis',
                                        'size',
                                        'größe',
                                        'gesamturteil',
                                        'overall_grade',
                                    ];
                                    if (in_array(strtolower($attr->name), $skipAttributes)) {
                                        continue;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $attr->name }}</td>
                                    <td class="is-primary">
                                        @php
                                            $val = $mainTest?->data[$attr->id] ?? null;
                                        @endphp
                                        @if ($val === null)
                                            <span class="bool-na">—</span>
                                        @elseif ($attr->type === 'boolean')
                                            {!! $val ? '<span class="bool-y">✓ Yes</span>' : '<span class="bool-n">✗ No</span>' !!}
                                        @else
                                            {{ $val }}
                                        @endif
                                    </td>
                                    @foreach ($similarProducts as $sim)
                                        <td>
                                            @php
                                                $simVal = $productTests->get($sim->id)?->data[$attr->id] ?? null;
                                            @endphp
                                            @if ($simVal === null)
                                                <span class="bool-na">—</span>
                                            @elseif ($attr->type === 'boolean')
                                                {!! $simVal ? '<span class="bool-y">✓ Yes</span>' : '<span class="bool-n">✗ No</span>' !!}
                                            @else
                                                {{ $simVal }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="row-overall">
                                <td>{{ d_trans('Gesamturteil') }}</td>
                                <td class="is-primary">
                                    {!! $gradeChip($overallGrades->get($product->id)) !!}
                                </td>
                                @foreach ($similarProducts as $sim)
                                    <td>
                                        {!! $gradeChip($overallGrades->get($sim->id)) !!}
                                    </td>
                                @endforeach
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        @endif
    @else
        <div style="height:100vh;display:flex;align-items:center;justify-content:center;">
            @include('themes.basic.partials.plan-exceed-modal')
        </div>
    @endif

@endsection
