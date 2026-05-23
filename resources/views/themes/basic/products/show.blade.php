@extends('themes.basic.layouts.single')
@section('title', d_trans($product->name))
@section('header_title', d_trans($product->name))
@section('description', d_trans($product->description))
@section('keywords', $product->brand_name . ',' . d_trans($product->name))
@section('breadcrumbs', Breadcrumbs::render('products.show', $product))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'products.show', $product))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')
    @push('styles')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

            :root {
                --cr: #f6f1e8;
                --cr2: #ede7d9;
                --cr3: #e4dccb;
                --gd: #18281a;
                --ta: #b8935a;
                --td: #111714;
                --tm: #374035;
                --tl: #6b7566;
                --bd: #d6d0c4;
                --bd2: #c8c1b4;
                --gg: #15803d;
                --ggb: #dcfce7;
                --gg2: #bbf7d0;
                --gr: #dc2626;
                --grb: #fee2e2;
                --gr2: #fecaca;
                --go: #b45309;
                --gob: #fef3c7;
                --go2: #fde68a;
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

            .shell {
                font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                background: var(--cr);
                border-radius: 20px;
                overflow: hidden;
                box-shadow: var(--s3), 0 0 0 1px rgba(0, 0, 0, .06);
            }

            /* HEADER */
            .prod-header {
                background: var(--gd);
                background-image: radial-gradient(ellipse at 80% 50%, rgba(184, 147, 90, .12) 0%, transparent 60%);
                padding: 20px 26px;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 16px;
                border-bottom: 1px solid rgba(255, 255, 255, .06);
            }

            .prod-header-left {
                display: flex;
                flex-direction: column;
                gap: 7px;
                min-width: 0;
            }

            .prod-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                font-size: .68rem;
                letter-spacing: .16em;
                text-transform: uppercase;
                color: var(--ta);
                font-weight: 700;
            }

            .prod-eyebrow::before {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--ta);
                flex-shrink: 0;
            }

            .prod-name-row {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .prod-oko-stamp {
                width: 72px;
                height: auto;
                flex-shrink: 0;
                object-fit: contain;
                filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.35));
            }

            .prod-name {
                font-size: 1.55rem;
                font-weight: 800;
                color: #fff;
                line-height: 1.18;
                letter-spacing: -.025em;
            }

            .prod-meta-strip {
                display: flex;
                gap: 8px;
                align-items: center;
                flex-wrap: wrap;
                font-size: .8rem;
                color: rgba(255, 255, 255, .45);
                font-weight: 500;
            }

            .prod-meta-sep {
                color: rgba(255, 255, 255, .2);
            }

            .grade-pill {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 5px 14px;
                border-radius: 999px;
                font-size: .78rem;
                font-weight: 700;
                letter-spacing: .01em;
                flex-shrink: 0;
                margin-top: 4px;
            }

            .grade-pill::before {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: currentColor;
                opacity: .65;
                flex-shrink: 0;
            }

            .gp-good {
                background: var(--ggb);
                color: var(--gg);
                box-shadow: 0 0 0 1px var(--gg2);
            }

            .gp-poor {
                background: var(--grb);
                color: var(--gr);
                box-shadow: 0 0 0 1px var(--gr2);
            }

            .gp-ok {
                background: var(--gob);
                color: var(--go);
                box-shadow: 0 0 0 1px var(--go2);
            }

            .gp-na {
                background: #f1f5f9;
                color: #64748b;
                box-shadow: 0 0 0 1px #cbd5e1;
            }

            /* BODY */
            .prod-body {
                display: grid;
                grid-template-columns: 300px 1fr;
            }

            /* LEFT */
            .left-col {
                background: var(--cr2);
                border-right: 1px solid var(--bd);
                display: flex;
                flex-direction: column;
            }

            .img-wrap {
                padding: 16px;
                background: #fff;
                border-bottom: 1px solid var(--bd);
            }

            .img-main {
                width: 100%;
                aspect-ratio: 1/1;
                border-radius: 12px;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--cr);
                border: 1px solid var(--bd);
            }

            .img-main img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .thumbs-row {
                display: flex;
                gap: 8px;
                margin-top: 10px;
            }

            .img-thumb {
                flex: 1;
                aspect-ratio: 1/1;
                border-radius: 8px;
                overflow: hidden;
                border: 2px solid transparent;
                cursor: pointer;
                transition: border-color .15s, transform .2s, box-shadow .2s;
                background: var(--cr2);
            }

            .img-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .img-thumb.active {
                border-color: var(--gd);
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(0, 0, 0, .12);
            }

            .img-thumb-more {
                flex: 1;
                aspect-ratio: 1/1;
                border: 2px dashed var(--bd2);
                border-radius: 8px;
                background: rgba(44, 61, 46, .05);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: .82rem;
                font-weight: 700;
                color: var(--tl);
                transition: all .15s;
                font-family: inherit;
            }

            .img-thumb-more:hover {
                border-color: var(--gd);
                background: rgba(44, 61, 46, .1);
                color: var(--gd);
            }

            /* Left sections */
            .left-section {
                padding: 16px;
                border-bottom: 1px solid var(--bd);
            }

            .left-section:last-child {
                border-bottom: none;
            }

            .section-label {
                font-size: .64rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: var(--tl);
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .section-label::after {
                content: '';
                flex: 1;
                height: 1px;
                background: var(--bd);
            }

            /* Entity cards */
            .entity-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .entity-card {
                display: flex;
                align-items: center;
                gap: 12px;
                background: #fff;
                border: 1px solid var(--bd);
                border-radius: 12px;
                padding: 12px 14px;
                text-decoration: none;
                transition: box-shadow .15s, border-color .15s, transform .15s;
                box-shadow: var(--s1);
            }

            .entity-card:hover {
                border-color: var(--bd2);
                box-shadow: var(--s2);
                transform: translateY(-1px);
            }

            .entity-logo {
                width: 44px;
                height: 44px;
                border-radius: 8px;
                object-fit: contain;
                flex-shrink: 0;
                background: var(--cr);
                padding: 5px;
                border: 1px solid var(--bd);
            }

            .entity-info {
                display: flex;
                flex-direction: column;
                gap: 3px;
                min-width: 0;
                flex: 1;
            }

            .entity-type {
                font-size: .6rem;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: var(--tl);
                font-weight: 600;
            }

            .entity-name {
                font-size: .9rem;
                font-weight: 700;
                color: var(--td);
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .entity-arrow {
                color: var(--bd2);
                font-size: 1.1rem;
                flex-shrink: 0;
                transition: color .15s, transform .15s;
            }

            .entity-card:hover .entity-arrow {
                color: var(--gd);
                transform: translateX(2px);
            }

            /* Concerns */
            .concern-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
                max-height: 220px;
                overflow-y: auto;
            }

            .concern-item {
                background: #fff;
                border: 1px solid var(--bd);
                border-radius: 10px;
                padding: 10px 12px;
                border-left: 3px solid var(--gr);
                box-shadow: var(--s1);
            }

            .concern-item.lv-medium {
                border-left-color: var(--go);
            }

            .concern-item.lv-low {
                border-left-color: var(--gg);
            }

            .concern-name {
                font-size: .82rem;
                font-weight: 700;
                color: var(--td);
                display: flex;
                align-items: center;
                gap: 6px;
                flex-wrap: wrap;
                margin-bottom: 4px;
            }

            .concern-desc {
                font-size: .75rem;
                color: var(--tm);
                line-height: 1.5;
            }

            .concern-meta {
                font-size: .66rem;
                color: var(--tl);
                margin-top: 5px;
                display: flex;
                gap: 8px;
            }

            .sev-badge {
                padding: 2px 7px;
                border-radius: 999px;
                font-size: .62rem;
                font-weight: 700;
            }

            .sev-high {
                background: var(--grb);
                color: var(--gr);
            }

            .sev-medium {
                background: var(--gob);
                color: var(--go);
            }

            .sev-low {
                background: var(--ggb);
                color: var(--gg);
            }

            /* RIGHT */
            .right-col {
                display: flex;
                flex-direction: column;
            }

            /* Stat bar */
            .stat-bar {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                border-bottom: 1px solid var(--bd);
                background: #fff;
            }

            .stat-cell {
                padding: 16px 20px;
                border-right: 1px solid var(--bd);
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .stat-cell:last-child {
                border-right: none;
            }

            .stat-lbl {
                font-size: .62rem;
                text-transform: uppercase;
                letter-spacing: .09em;
                color: var(--tl);
                font-weight: 600;
            }

            .stat-val {
                font-size: .96rem;
                font-weight: 700;
                color: var(--td);
                line-height: 1.3;
            }

            /* Description */
            .desc-strip {
                padding: 16px 22px;
                border-bottom: 1px solid var(--bd);
                font-size: .9rem;
                line-height: 1.7;
                color: var(--tm);
            }

            /* Tabs */
            .tab-bar {
                display: flex;
                border-bottom: 1px solid var(--bd);
                padding: 0 22px;
                background: var(--cr2);
            }

            .tab-btn {
                padding: 13px 16px;
                font-size: .82rem;
                font-weight: 600;
                color: var(--tl);
                background: none;
                border: none;
                border-bottom: 2px solid transparent;
                margin-bottom: -1px;
                cursor: pointer;
                transition: color .15s, border-color .15s;
                font-family: inherit;
            }

            .tab-btn.active {
                color: var(--gd);
                border-bottom-color: var(--gd);
            }

            .tab-btn:hover:not(.active) {
                color: var(--tm);
            }

            .tab-panel {
                display: none;
            }

            .tab-panel.active {
                display: block;
            }

            /* Lab rows */
            .lab-rows {
                padding: 4px 22px 8px;
            }

            .lab-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 11px 0;
                border-bottom: 1px solid rgba(122, 130, 110, .15);
                gap: 12px;
            }

            .lab-row:last-child {
                border-bottom: none;
            }

            .lab-lbl {
                font-size: .82rem;
                color: var(--tl);
                font-weight: 500;
            }

            .lab-val {
                font-size: .84rem;
                font-weight: 700;
                color: var(--td);
                text-align: right;
            }

            .bool-y {
                color: var(--gg);
                font-weight: 700;
            }

            .bool-n {
                color: var(--gr);
                font-weight: 700;
            }

            .bool-na {
                color: var(--tl);
            }

            /* Summary */
            .summary-box {
                margin: 4px 22px 16px;
                background: rgba(24, 40, 26, .04);
                border: 1px solid var(--bd);
                border-radius: 10px;
                padding: 14px 16px;
            }

            .summary-box p {
                font-size: .84rem;
                color: var(--tm);
                line-height: 1.65;
            }

            /* ─── Tab count badge ────────────────────────────────── */
            .tab-count-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 18px;
                height: 18px;
                padding: 0 5px;
                border-radius: 999px;
                background: var(--gr);
                color: #fff;
                font-size: .62rem;
                font-weight: 700;
                line-height: 1;
                margin-left: 5px;
            }

            /* ─── Ingredient Concerns tab ────────────────────────── */
            .concerns-panel {
                padding: 20px 22px 28px;
            }

            .concerns-summary {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 18px;
                padding-bottom: 16px;
                border-bottom: 1px solid var(--bd);
            }

            .concerns-summary-chip {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 10px;
                border-radius: 999px;
                font-size: .72rem;
                font-weight: 700;
            }

            .chip-dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: currentColor;
                opacity: .7;
                flex-shrink: 0;
            }

            .chip-high   { background: var(--grb); color: var(--gr); }
            .chip-medium { background: var(--gob); color: var(--go); }
            .chip-low    { background: var(--ggb); color: var(--gg); }

            .concerns-total {
                margin-left: auto;
                font-size: .75rem;
                color: var(--tl);
                font-weight: 500;
            }

            .concerns-list {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .concern-card {
                background: #fff;
                border: 1px solid var(--bd);
                border-left: 4px solid var(--gr);
                border-radius: 10px;
                padding: 14px 16px;
                box-shadow: var(--s1);
            }

            .concern-card.lv-medium { border-left-color: var(--go); }
            .concern-card.lv-low    { border-left-color: var(--gg); }

            .concern-card-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 6px;
            }

            .concern-card-name {
                font-size: .88rem;
                font-weight: 700;
                color: var(--td);
            }

            .concern-card-desc {
                font-size: .8rem;
                color: var(--tm);
                line-height: 1.6;
                margin-bottom: 6px;
            }

            .concern-card-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                font-size: .74rem;
                color: var(--tl);
                margin-top: 4px;
            }

            .concerns-empty {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 36px 16px;
                gap: 10px;
            }

            .concerns-empty-icon {
                font-size: 2rem;
                color: var(--gg);
                margin-bottom: 4px;
            }

            .concerns-empty-title {
                font-size: .95rem;
                font-weight: 700;
                color: var(--td);
            }

            .concerns-empty-sub {
                font-size: .82rem;
                color: var(--tl);
                line-height: 1.6;
                max-width: 340px;
            }

            /* ─── Certifications tab ─────────────────────────────── */
            .cert-panel {
                padding: 24px 22px 28px;
            }

            .cert-title {
                font-size: .65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .12em;
                color: var(--tl);
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .cert-title::after {
                content: '';
                flex: 1;
                height: 1px;
                background: var(--bd);
            }

            .cert-body {
                display: flex;
                align-items: flex-start;
                gap: 24px;
            }

            .cert-stamp {
                width: 110px;
                height: auto;
                flex-shrink: 0;
                object-fit: contain;
            }

            .cert-copy {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .cert-copy p {
                font-size: .88rem;
                line-height: 1.72;
                color: var(--tm);
                margin: 0;
            }

            .cert-empty {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 32px 16px;
                gap: 10px;
            }

            .cert-empty-icon {
                width: 52px;
                height: 52px;
                border-radius: 50%;
                background: #f1f5f9;
                border: 1px solid var(--bd);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem;
                color: #94a3b8;
                margin-bottom: 4px;
            }

            .cert-empty-title {
                font-size: .95rem;
                font-weight: 700;
                color: var(--td);
            }

            .cert-empty-sub {
                font-size: .82rem;
                color: var(--tl);
                line-height: 1.6;
                max-width: 360px;
            }

            @media (max-width: 560px) {
                .cert-body {
                    flex-direction: column;
                    align-items: center;
                }
            }

            /* Comparison */
            .cmp-strip {
                padding: 18px 22px;
                background: linear-gradient(135deg, #fff 0%, var(--cr) 100%);
                border-top: 1px solid var(--bd);
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }

            .cmp-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: .63rem;
                font-weight: 700;
                letter-spacing: .1em;
                text-transform: uppercase;
                color: #9b1a1a;
                background: #fff0f0;
                border: 1px solid #fca5a5;
                padding: 4px 10px;
                border-radius: 999px;
                margin-bottom: 7px;
            }

            .cmp-title {
                font-size: 1rem;
                font-weight: 800;
                color: var(--td);
                margin-bottom: 4px;
                letter-spacing: -.01em;
            }

            .cmp-sub {
                font-size: .8rem;
                color: var(--tl);
                max-width: 400px;
                line-height: 1.5;
            }

            .cmp-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                flex-shrink: 0;
                font-size: .84rem;
                font-weight: 700;
                color: #9b1a1a;
                text-decoration: none;
                padding: 11px 22px;
                border: 2px solid #9b1a1a;
                border-radius: 8px;
                background: #fff;
                transition: all .15s;
                white-space: nowrap;
                font-family: inherit;
                box-shadow: var(--s1);
            }

            .cmp-btn:hover {
                background: #9b1a1a;
                color: #fff;
                box-shadow: 0 6px 20px rgba(155, 26, 26, .3);
                transform: translateY(-1px);
            }

            /* Modal */
            .modal-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .75);
                z-index: 9999;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .modal-overlay.open {
                display: flex;
            }

            .modal-box {
                background: #fff;
                border-radius: 16px;
                padding: 20px;
                max-width: 86vw;
                max-height: 86vh;
                overflow-y: auto;
                position: relative;
                box-shadow: var(--s3);
                font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            }

            .modal-close {
                position: absolute;
                top: 12px;
                right: 12px;
                width: 30px;
                height: 30px;
                background: var(--cr2);
                border: 1px solid var(--bd);
                border-radius: 50%;
                cursor: pointer;
                font-size: 1rem;
                color: var(--td);
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background .15s;
            }

            .modal-close:hover {
                background: var(--cr3);
            }

            .modal-title {
                font-size: .9rem;
                font-weight: 700;
                color: var(--td);
                margin-bottom: 14px;
            }

            .modal-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
                gap: 8px;
            }

            .modal-img {
                aspect-ratio: 1/1;
                border-radius: 8px;
                overflow: hidden;
                border: 2px solid transparent;
                cursor: pointer;
                transition: all .15s;
            }

            .modal-img:hover {
                border-color: var(--gd);
                transform: scale(1.04);
            }

            .modal-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .modal-2col {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0 24px;
            }

            .btn-show-more {
                display: block;
                width: 100%;
                padding: 12px;
                text-align: center;
                background: var(--cr2);
                border: 1px dashed var(--bd);
                border-radius: 8px;
                color: var(--td);
                font-weight: 600;
                font-size: .85rem;
                margin-top: 4px;
                cursor: pointer;
                transition: background .15s, border-color .15s;
                font-family: inherit;
            }

            .btn-show-more:hover {
                background: var(--cr3);
                border-color: var(--gd);
            }

            @media (max-width:900px) {
                .modal-2col {
                    grid-template-columns: 1fr;
                }

                .prod-body {
                    grid-template-columns: 1fr;
                }

                .left-col {
                    border-right: none;
                    border-bottom: 1px solid var(--bd);
                }

                .stat-bar {
                    grid-template-columns: repeat(3, 1fr);
                }

                .stat-cell:nth-child(3) {
                    border-right: none;
                }
            }

            @media (max-width:560px) {
                .prod-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .cmp-strip {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .prod-name {
                    font-size: 1.25rem;
                }
            }

            /* ─── Hazard Score Bar ───────────────────────────── */
            .hazard-row {
                background: #f8f9f4;
                border-bottom: 1px solid var(--bd);
                padding: 16px 26px;
                display: flex;
                align-items: center;
                gap: 20px;
                flex-wrap: wrap;
            }

            .hazard-left {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 4px;
                flex-shrink: 0;
            }

            .hazard-stamp {
                width: 46px;
                height: auto;
                object-fit: contain;
            }

            .hazard-stamp-lbl {
                font-size: .55rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .07em;
                color: var(--gd);
                text-align: center;
                line-height: 1.25;
            }

            .hazard-divider {
                width: 1px;
                height: 52px;
                background: var(--bd);
                flex-shrink: 0;
            }

            .hazard-scale {
                display: flex;
                align-items: center;
                gap: 10px;
                flex: 1;
                min-width: 0;
            }

            .hazard-edge {
                font-size: .68rem;
                font-weight: 700;
                color: var(--tl);
                flex-shrink: 0;
                text-transform: uppercase;
                letter-spacing: .05em;
            }

            .hazard-nums {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .hazard-num {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: var(--hc);
                color: #fff;
                font-size: .8rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                user-select: none;
                transition: transform .15s;
            }

            .hazard-num.hazard-active {
                width: 52px;
                height: 52px;
                font-size: 1.15rem;
                font-weight: 800;
                box-shadow: 0 0 0 3px #fff, 0 0 0 5px var(--hc), 0 6px 18px rgba(0,0,0,.2);
                position: relative;
                z-index: 1;
            }

            .hazard-legend {
                display: flex;
                flex-direction: column;
                gap: 6px;
                flex-shrink: 0;
                padding-left: 20px;
                border-left: 1px solid var(--bd);
            }

            .hazard-legend-item {
                display: flex;
                align-items: center;
                gap: 7px;
                font-size: .72rem;
                font-weight: 600;
                color: var(--tm);
            }

            .hazard-dot {
                width: 9px;
                height: 9px;
                border-radius: 50%;
                background: var(--hc);
                flex-shrink: 0;
            }

            @media (max-width: 760px) {
                .hazard-row { gap: 12px; padding: 12px 16px; }
                .hazard-divider { display: none; }
                .hazard-legend { border-left: none; padding-left: 0; flex-direction: row; flex-wrap: wrap; gap: 8px; }
                .hazard-num { width: 28px; height: 28px; font-size: .72rem; }
                .hazard-num.hazard-active { width: 40px; height: 40px; font-size: .95rem; }
            }
        </style>
    @endpush

    @php
        $productImageUrls = collect([$product->image])
            ->merge($product->images->pluck('path'))
            ->filter()
            ->map(fn($p) => \Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p))
            ->unique()
            ->values();
        if ($productImageUrls->isEmpty()) {
            $productImageUrls = collect([$product->getImageLink()]);
        }

        $productTest = $product->productTest;
        $testData = $productTest?->data ?? [];
        $concerns = $product->ingredientConcerns ?? collect();

        $g = $product->overall_grade;
        $gpClass = $g
            ? (in_array($g, ['very_good', 'good'])
                ? 'gp-good'
                : (in_array($g, ['poor', 'bad'])
                    ? 'gp-poor'
                    : 'gp-ok'))
            : 'gp-na';
        $gpLabel = $g ? str_replace('_', ' ', ucfirst($g)) : 'N/A';
    @endphp

    @if ($canSeeDetails)
        <div class="shell">

            {{-- HAZARD SCORE BAR --}}
            @if (!is_null($product->hazard_score))
            @php
                $hs = $product->hazard_score;
                $hsActiveColor = $hs <= 2 ? '#16a34a' : ($hs <= 6 ? '#ea580c' : '#dc2626');
                $hsConcernLabel = $hs <= 2
                    ? d_trans('Low Concern — Safer Choice')
                    : ($hs <= 6 ? d_trans('Medium Concern') : d_trans('High Concern'));
            @endphp
            <div class="hazard-row">
                <div class="hazard-left">
                    <img src="{{ asset('images/oko/stamp-verification.webp') }}" class="hazard-stamp" alt="OKO">
                    <span class="hazard-stamp-lbl">OKO<br>VERIFIED</span>
                </div>

                <div class="hazard-divider"></div>

                <div class="hazard-scale">
                    <span class="hazard-edge">{{ d_trans('Best') }}</span>
                    <div class="hazard-nums">
                        @for ($i = 1; $i <= 10; $i++)
                            @php
                                $iColor = $i <= 2 ? '#16a34a' : ($i <= 6 ? '#ea580c' : '#dc2626');
                            @endphp
                            <div class="hazard-num {{ $hs == $i ? 'hazard-active' : '' }}"
                                 style="--hc: {{ $iColor }}">{{ $i }}</div>
                        @endfor
                    </div>
                    <span class="hazard-edge">{{ d_trans('Worst') }}</span>
                </div>

                <div class="hazard-legend">
                    <div class="hazard-legend-item" style="--hc: #16a34a">
                        <span class="hazard-dot"></span>
                        {{ d_trans('1–2 Low Concern / Safer') }}
                    </div>
                    <div class="hazard-legend-item" style="--hc: #ea580c">
                        <span class="hazard-dot"></span>
                        {{ d_trans('3–6 Medium Concern') }}
                    </div>
                    <div class="hazard-legend-item" style="--hc: #dc2626">
                        <span class="hazard-dot"></span>
                        {{ d_trans('7–10 High Concern') }}
                    </div>
                </div>
            </div>
            @endif

            {{-- HEADER --}}
            <div class="prod-header">
                <div class="prod-header-left">
                    <span class="prod-eyebrow">{{ d_trans('Lab-Tested Product') }}</span>
                    <div class="prod-name-row">
                        {{-- @if ($product->oko_verified)
                            <img src="{{ asset('images/oko/stamp-verification.webp') }}" alt="OKO Verified"
                                class="prod-oko-stamp">
                        @endif --}}
                        <h1 class="prod-name">{{ d_trans($product->name) }}</h1>
                    </div>
                    <div class="prod-meta-strip">
                        <span>{{ $product->brand?->name ?: d_trans('Unknown Brand') }}</span>
                        <span class="prod-meta-sep">·</span>
                        <span>{{ $product->category->trans->name ?? d_trans('Uncategorized') }}</span>
                        @if ($product->subCategory)
                            <span class="prod-meta-sep">·</span>
                            <span>{{ $product->subCategory->trans->name }}</span>
                        @endif
                    </div>
                </div>
                <span class="grade-pill {{ $gpClass }}">{{ $gpLabel }}</span>
            </div>

            {{-- BODY --}}
            <div class="prod-body">

                {{-- LEFT --}}
                <div class="left-col">
                    <div class="img-wrap">
                        <div class="img-main">
                            <img id="mainProductImage" src="{{ $productImageUrls->first() }}"
                                alt="{{ d_trans($product->name) }}">
                        </div>
                        @if ($productImageUrls->count() > 1)
                            <div class="thumbs-row">
                                @foreach ($productImageUrls->take(3) as $i => $url)
                                    <button class="img-thumb {{ $i === 0 ? 'active' : '' }}"
                                        onclick="selectPreview(this,'{{ $url }}')">
                                        <img src="{{ $url }}" alt="">
                                    </button>
                                @endforeach
                                @if ($productImageUrls->count() > 3)
                                    <button class="img-thumb-more" onclick="openImageModal()">
                                        +{{ $productImageUrls->count() - 3 }} more
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Brand & Category --}}
                    <div class="left-section">
                        <div class="section-label">{{ d_trans('Brand & Category') }}</div>
                        <div class="entity-list">
                            <a class="entity-card" href="#">
                                <img class="entity-logo" src="{{ asset($product->brand?->logo) }}"
                                    alt="{{ $product->brand?->name }}">
                                <div class="entity-info">
                                    <div class="entity-type">{{ d_trans('Brand') }}</div>
                                    <div class="entity-name">{{ $product->brand?->name ?: 'N/A' }}</div>
                                </div>
                                <span class="entity-arrow">›</span>
                            </a>
                            <a class="entity-card" href="#">
                                <img class="entity-logo" src="{{ asset($product->category->image) }}"
                                    alt="{{ $product->category->trans->name }}">
                                <div class="entity-info">
                                    <div class="entity-type">{{ d_trans('Category') }}</div>
                                    <div class="entity-name">{{ $product->category->trans->name ?: 'N/A' }}</div>
                                </div>
                                <span class="entity-arrow">›</span>
                            </a>
                            @if ($product->subCategory)
                                <a class="entity-card" href="#">
                                    <img class="entity-logo" src="{{ asset($product->subCategory->image) }}"
                                        alt="{{ $product->subCategory->trans->name }}">
                                    <div class="entity-info">
                                        <div class="entity-type">{{ d_trans('Sub-Category') }}</div>
                                        <div class="entity-name">{{ $product->subCategory->trans->name }}</div>
                                    </div>
                                    <span class="entity-arrow">›</span>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>{{-- /left-col --}}

                {{-- RIGHT --}}
                <div class="right-col">

                    <div class="stat-bar">
                        <div class="stat-cell">
                            <div class="stat-lbl"><i class="fas fa-star"></i> {{ d_trans('Overall Grade') }}</div>
                            <div class="stat-val"><span class="grade-pill {{ $gpClass }}">{{ $gpLabel }}</span>
                            </div>
                        </div>
                        <div class="stat-cell">
                            <div class="stat-lbl"><i class="fas fa-microscope"></i> {{ d_trans('Test Name') }}</div>
                            <div class="stat-val">{{ d_trans($productTest?->name) ?: '—' }}</div>
                        </div>
                        <div class="stat-cell">
                            <div class="stat-lbl"><i class="fas fa-tag"></i> {{ d_trans('Price') }}</div>
                            <div class="stat-val">
                                {{ $product->price ? $product->currency . ' ' . numberFormat($product->price) : '—' }}
                            </div>
                        </div>
                        <div class="stat-cell">
                            <div class="stat-lbl"><i class="fas fa-weight-hanging"></i> {{ d_trans('Size') }}</div>
                            <div class="stat-val">{{ $product->product_size ?: '—' }}</div>
                        </div>
                        <div class="stat-cell">
                            <div class="stat-lbl"><i class="fas fa-biohazard"></i> {{ d_trans('Hazard Score') }}</div>
                            @php
                                $hs = $product->hazard_score;
                                $hsColor = is_null($hs) ? 'var(--tl)' : ($hs <= 3 ? 'var(--gg)' : ($hs <= 6 ? 'var(--go)' : 'var(--gr)'));
                            @endphp
                            <div class="stat-val" style="color: {{ $hsColor }}">
                                {{ is_null($hs) ? '—' : $hs . ' / 10' }}
                            </div>
                        </div>
                    </div>

                    @if (d_trans($product->description))
                        <div class="desc-strip">
                            {{ \Illuminate\Support\Str::limit(strip_tags(d_trans($product->description)), 300) }}
                        </div>
                    @endif

                    <div class="tab-bar">
                        <button class="tab-btn active" onclick="switchTab(this,'tab-concerns')">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ d_trans('Ingredient Concerns') }}
                            @if ($concerns->count() > 0)
                                <span class="tab-count-badge">{{ $concerns->count() }}</span>
                            @endif
                        </button>
                        <button class="tab-btn" onclick="switchTab(this,'tab-snap')"><i
                                class="fas fa-microscope"></i> {{ d_trans('Lab Snapshot') }}</button>
                        <button class="tab-btn" onclick="switchTab(this,'tab-full')"><i class="fas fa-file-alt"></i>
                            {{ d_trans('Full Details') }}</button>
                        <button class="tab-btn" onclick="switchTab(this,'tab-cert')"><i class="fas fa-certificate"></i>
                            {{ d_trans('Certifications') }}</button>
                    </div>

                    <div class="tab-panel" id="tab-snap">
                        <div class="lab-rows">
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Test Name') }}</span>
                                <span class="lab-val">{{ d_trans($productTest?->name) ?: '—' }}</span>
                            </div>
                            @if ($productTest && $testAttributes->count() > 0)
                                @foreach ($testAttributes->take(6) as $attr)
                                    @php
                                        $value = $testData[$attr->id] ?? null;
                                    @endphp
                                    <div class="lab-row">
                                        <span class="lab-lbl">{{ d_trans($attr->name) }}</span>
                                        <span class="lab-val">{{ d_trans($value) ?: '—' }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="lab-row">
                                    <span class="lab-lbl">{{ d_trans('Test Data') }}</span>
                                    <span class="lab-val"><span
                                            class="bool-na">{{ d_trans('No test data available') }}</span></span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="tab-panel" id="tab-full">
                        <div class="lab-rows">
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Test Name') }}</span>
                                <span class="lab-val">{{ d_trans($productTest?->name) ?: '—' }}</span>
                            </div>
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Lab Verified') }}</span>
                                <span class="lab-val">{{ $product->lab_verified ? '✓ Yes' : '✗ No' }}</span>
                            </div>
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Test Date') }}</span>
                                <span class="lab-val">{{ $product->test_date?->format('M d, Y') ?: '—' }}</span>
                            </div>
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Test Year') }}</span>
                                <span class="lab-val">{{ $product->test_year ?: '—' }}</span>
                            </div>
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Test Edition') }}</span>
                                <span class="lab-val">{{ $product->test_edition ?: '—' }}</span>
                            </div>
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Organic Certified') }}</span>
                                <span class="lab-val">{{ $product->organic_certified ? '✓ Yes' : '✗ No' }}</span>
                            </div>
                            <div class="lab-row">
                                <span class="lab-lbl">{{ d_trans('Organic Certifier') }}</span>
                                <span class="lab-val">{{ $product->organic_certifier ?: '—' }}</span>
                            </div>
                            @if ($productTest && $testAttributes->count() > 0)
                                @foreach ($testAttributes as $attr)
                                    @php
                                        $value = $testData[$attr->id] ?? null;
                                    @endphp
                                    <div class="lab-row">
                                        <span class="lab-lbl">{{ d_trans($attr->name) }}</span>
                                        <span class="lab-val">{{ d_trans($value) ?: '—' }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Certifications tab --}}
                    <div class="tab-panel" id="tab-cert">
                        <div class="cert-panel">
                            @if ($product->oko_verified)
                                <div class="cert-title">{{ d_trans('OKO Verified') }}</div>
                                <div class="cert-body">
                                    <img src="{{ asset('images/oko/stamp-verification.webp') }}" alt="OKO Verified"
                                        class="cert-stamp">
                                    <div class="cert-copy">
                                        <p>{{ d_trans('This product carries the OKO Verified mark, indicating that its formula has undergone an independent safety and quality review by OKO scientists.
                                        
                                        The brand has shown that the ingredients used in this product align with OKO’s high standards for safety, quality, and responsible formulation.') }}
                                        </p>
                                        <p>{{ d_trans('At the time of verification, the product’s ingredients were assessed using the latest available scientific understanding and were not found to present major concerns for human health.') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="cert-empty">
                                    <div class="cert-empty-icon">
                                        <i class="fas fa-certificate"></i>
                                    </div>
                                    <div class="cert-empty-title">{{ d_trans('Not Yet Certified') }}</div>
                                    <div class="cert-empty-sub">
                                        {{ d_trans('This product has not yet received OKO Verified certification. Certification requires an independent safety review of all formulation ingredients.') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Ingredient Concerns tab --}}
                    <div class="tab-panel active" id="tab-concerns">
                        <div class="concerns-panel">
                            @if ($concerns->count() > 0)
                                @php
                                    $highCount   = $concerns->where('severity', 'high')->count();
                                    $mediumCount = $concerns->where('severity', 'medium')->count();
                                    $lowCount    = $concerns->where('severity', 'low')->count();
                                @endphp
                                <div class="concerns-summary">
                                    @if ($highCount)
                                        <div class="concerns-summary-chip chip-high">
                                            <span class="chip-dot"></span>{{ $highCount }} {{ d_trans('High') }}
                                        </div>
                                    @endif
                                    @if ($mediumCount)
                                        <div class="concerns-summary-chip chip-medium">
                                            <span class="chip-dot"></span>{{ $mediumCount }} {{ d_trans('Medium') }}
                                        </div>
                                    @endif
                                    @if ($lowCount)
                                        <div class="concerns-summary-chip chip-low">
                                            <span class="chip-dot"></span>{{ $lowCount }} {{ d_trans('Low') }}
                                        </div>
                                    @endif
                                    <span class="concerns-total">{{ $concerns->count() }} {{ d_trans('total concerns found') }}</span>
                                </div>
                                <div class="concerns-list">
                                    @foreach ($concerns as $concern)
                                        <div class="concern-card lv-{{ strtolower($concern->severity) }}">
                                            <div class="concern-card-head">
                                                <span class="concern-card-name">{{ $concern->ingredient_name }}</span>
                                                <span class="sev-badge sev-{{ strtolower($concern->severity) }}">{{ ucfirst($concern->severity) }}</span>
                                            </div>
                                            @if ($concern->description)
                                                <div class="concern-card-desc">{{ $concern->description }}</div>
                                            @endif
                                            @if ($concern->inci_name || $concern->concentration)
                                                <div class="concern-card-meta">
                                                    @if ($concern->inci_name)
                                                        <span><strong>INCI:</strong> {{ $concern->inci_name }}</span>
                                                    @endif
                                                    @if ($concern->concentration)
                                                        <span><strong>{{ d_trans('Concentration') }}:</strong> {{ number_format((float) $concern->concentration, 4) }}%</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="concerns-empty">
                                    <div class="concerns-empty-icon"><i class="fas fa-check-circle"></i></div>
                                    <div class="concerns-empty-title">{{ d_trans('No Ingredient Concerns') }}</div>
                                    <div class="concerns-empty-sub">{{ d_trans('No flagged or concerning ingredients were identified in this product\'s formulation.') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="cmp-strip">
                        <div>
                            <div class="cmp-badge">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                {{ d_trans('Side-by-Side Analysis') }}
                            </div>
                            <div class="cmp-title">{{ d_trans('Compare with Similar Products') }}</div>
                            <div class="cmp-sub">
                                {{ d_trans('Stack it against alternatives — specs, price, and performance in one view.') }}
                            </div>
                        </div>
                        <a href="{{ route('products.comparison', $product->id) }}" class="cmp-btn">
                            {{ d_trans('View Comparison') }}
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                </div>{{-- /right-col --}}
            </div>{{-- /prod-body --}}
        </div>{{-- /shell --}}

        {{-- Hazard Score Info + OKO Verification Info --}}
        <div class="hsi-grid mt-4">

            {{-- Left: Hazard Score Explained --}}
            <div class="hsi-card">
                <h2 class="hsi-title">{{ d_trans('Hazard Score') }}</h2>
                <p class="hsi-lead">
                    {{ d_trans('Our ingredient hazard score runs from 1 to 10 and reflects the level of known and potential health concerns associated with a product\'s ingredients. A lower number signals a safer formulation, while a higher number indicates greater cause for caution. An OKO Verified mark alongside the score means the product has additionally satisfied our strictest standards for ingredient transparency and consumer safety.') }}
                </p>

                <div class="hsi-scale-wrap">
                    <div class="hsi-scale-inner">
                        <div class="hsi-scale-left">
                            <img src="{{ asset('images/oko/stamp-verification.webp') }}" class="hsi-mini-stamp" alt="OKO">
                            <span class="hsi-mini-lbl">OKO<br>VERIFIED</span>
                        </div>
                        <span class="hsi-edge">{{ d_trans('Best') }}</span>
                        <div class="hsi-nums">
                            @for ($i = 1; $i <= 10; $i++)
                                @php $iColor = $i <= 2 ? '#16a34a' : ($i <= 6 ? '#ea580c' : '#dc2626'); @endphp
                                <div class="hsi-num" style="--hc: {{ $iColor }}">{{ $i }}</div>
                            @endfor
                        </div>
                        <span class="hsi-edge">{{ d_trans('Worst') }}</span>
                    </div>
                </div>

                <div class="hsi-approach">
                    <div class="hsi-approach-title">{{ d_trans('Evidence-Based Scoring') }}</div>
                    <p class="hsi-approach-text">
                        {{ d_trans('A product\'s hazard score is not a straight average of its ingredients\' individual scores. Instead, it is determined through a weight-of-evidence evaluation that considers all identified health hazards, potential exposure risks, and available toxicological data linked to the full ingredient list.') }}
                    </p>
                </div>
            </div>

            {{-- Right: OKO Verification Process --}}
            <div class="hsi-card">
                <h2 class="hsi-title">{{ d_trans('OKO Verification Process') }}</h2>

                <div class="hsi-verify-head">
                    <img src="{{ asset('images/oko/stamp-verification.webp') }}" class="hsi-verify-stamp" alt="OKO Verified">
                    <div>
                        <p class="hsi-verify-desc">
                            {{ d_trans('The OKO Verified mark on a product confirms that the brand\'s complete ingredient disclosures have undergone an independent review by OKO scientists. Products bearing this mark have demonstrated full compliance with our safety criteria, protecting the health and trust of every consumer.') }}
                        </p>
                    </div>
                </div>
                <div class="hsi-verify-label-lbl">{{ d_trans('OKO VERIFIED') }}</div>

                <div class="hsi-approach">
                    <div class="hsi-approach-title">{{ d_trans('A Product Qualifies for OKO Verification If It:') }}</div>
                    <ul class="hsi-criteria">
                        <li>{{ d_trans('Achieves an overall hazard score that meets OKO\'s established safety threshold') }}</li>
                        <li>{{ d_trans('Contains no ingredients appearing on OKO\'s Restricted Substances list') }}</li>
                        <li>{{ d_trans('Provides full ingredient disclosure, including all fragrance and preservative components') }}</li>
                    </ul>
                </div>
            </div>

        </div>

        @push('styles')
        <style>
            .hsi-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            .hsi-card {
                background: #f8faf5;
                border: 1px solid #d6e8d0;
                border-radius: 16px;
                padding: 28px 30px;
                display: flex;
                flex-direction: column;
                gap: 18px;
                font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            }

            .hsi-title {
                font-size: 1.2rem;
                font-weight: 800;
                color: #1a2e1c;
                text-align: center;
                letter-spacing: -.015em;
                margin: 0;
            }

            .hsi-lead {
                font-size: .84rem;
                color: #3d5440;
                line-height: 1.72;
                text-align: center;
                margin: 0;
            }

            .hsi-scale-wrap {
                background: #fff;
                border: 1px solid #d6e8d0;
                border-radius: 10px;
                padding: 12px 16px;
            }

            .hsi-scale-inner {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: nowrap;
            }

            .hsi-scale-left {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 3px;
                flex-shrink: 0;
                margin-right: 4px;
            }

            .hsi-mini-stamp {
                width: 32px;
                height: auto;
                object-fit: contain;
            }

            .hsi-mini-lbl {
                font-size: .48rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .06em;
                color: #1a2e1c;
                text-align: center;
                line-height: 1.2;
            }

            .hsi-edge {
                font-size: .65rem;
                font-weight: 700;
                color: #6b7566;
                flex-shrink: 0;
                text-transform: uppercase;
                letter-spacing: .04em;
            }

            .hsi-nums {
                display: flex;
                align-items: center;
                gap: 4px;
                flex: 1;
                justify-content: center;
            }

            .hsi-num {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background: var(--hc);
                color: #fff;
                font-size: .75rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                user-select: none;
            }

            .hsi-approach {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .hsi-approach-title {
                font-size: .72rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .08em;
                color: #1a2e1c;
            }

            .hsi-approach-text {
                font-size: .82rem;
                color: #3d5440;
                line-height: 1.7;
                margin: 0;
            }

            .hsi-verify-head {
                display: flex;
                align-items: flex-start;
                gap: 18px;
            }

            .hsi-verify-stamp {
                width: 90px;
                height: auto;
                flex-shrink: 0;
                object-fit: contain;
            }

            .hsi-verify-desc {
                font-size: .84rem;
                color: #3d5440;
                line-height: 1.72;
                margin: 0;
            }

            .hsi-verify-label-lbl {
                font-size: .7rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: #1a2e1c;
                text-align: center;
                margin-top: -10px;
            }

            .hsi-criteria {
                margin: 0;
                padding-left: 18px;
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .hsi-criteria li {
                font-size: .82rem;
                color: #3d5440;
                line-height: 1.6;
            }

            @media (max-width: 760px) {
                .hsi-grid { grid-template-columns: 1fr; }
                .hsi-verify-head { flex-direction: column; align-items: center; }
                .hsi-verify-label-lbl { margin-top: 0; }
            }
        </style>
        @endpush

        <div class="mt-4">
            @include('themes.basic.partials.user-reviews', [
                'userReviews' => $product->userReviews()->approved()->latest()->get(),
                'reviewProduct' => $product,
                'reviewAction' => route('products.reviews.store', $product->slug ?? $product->id),
            ])
        </div>

        <div class="modal-overlay" id="imageModal">
            <div class="modal-box">
                <button class="modal-close" onclick="closeModal()">&times;</button>
                <div class="modal-title">{{ d_trans('All Product Images') }}</div>
                <div class="modal-grid">
                    @foreach ($productImageUrls as $url)
                        <div class="modal-img" onclick="pickFromModal('{{ $url }}')">
                            <img src="{{ $url }}" alt="{{ d_trans($product->name) }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if ($productTest && $testAttributes->count() > 0)
            <div class="modal-overlay" id="detailsModal">
                <div class="modal-box" style="max-width: 800px; width: 100%;">
                    <button class="modal-close" onclick="closeDetailsModal()">&times;</button>
                    <div class="modal-title">{{ d_trans('Full Test Details') }}</div>
                    <div class="modal-2col">
                        @foreach ($testAttributes as $attr)
                            @php
                                $value = $testData[$attr->id] ?? null;
                            @endphp
                            <div class="lab-row" style="padding: 12px 0;">
                                <span class="lab-lbl">{{ d_trans($attr->name) }}</span>
                                <span class="lab-val">{{ $value ?: '—' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @push('scripts')
            <script>
                function selectPreview(el, url) {
                    document.getElementById('mainProductImage').src = url;
                    document.querySelectorAll('.img-thumb').forEach(t => t.classList.remove('active'));
                    el.classList.add('active');
                }

                function openImageModal() {
                    document.getElementById('imageModal').classList.add('open');
                    document.body.style.overflow = 'hidden';
                }

                function closeModal() {
                    document.getElementById('imageModal').classList.remove('open');
                    document.body.style.overflow = '';
                }

                function pickFromModal(url) {
                    document.getElementById('mainProductImage').src = url;
                    closeModal();
                }

                function switchTab(btn, id) {
                    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                    btn.classList.add('active');
                    document.getElementById(id).classList.add('active');
                }

                function openDetailsModal() {
                    document.getElementById('detailsModal').classList.add('open');
                    document.body.style.overflow = 'hidden';
                }

                function closeDetailsModal() {
                    document.getElementById('detailsModal').classList.remove('open');
                    document.body.style.overflow = '';
                }

                document.getElementById('imageModal')?.addEventListener('click', e => {
                    if (e.target === e.currentTarget) closeModal();
                });
                document.getElementById('detailsModal')?.addEventListener('click', e => {
                    if (e.target === e.currentTarget) closeDetailsModal();
                });
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') {
                        closeModal();
                        closeDetailsModal();
                    }
                });
            </script>
        @endpush
    @else
        <div style="height:100vh;display:flex;align-items:center;justify-content:center;">
            @include('themes.basic.partials.plan-exceed-modal')
        </div>
    @endif
@endsection
