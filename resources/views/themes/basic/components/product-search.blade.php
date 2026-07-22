<div class="oeko-hero-searchbar">
    <div class="header-search search home-search">
        <form action="{{ route('products.index') }}" data-ajax-action="{{ route('products.ajax-search') }}"
            data-ajax-empty="{{ d_trans('No results found') }}" method="GET">
            <div class="search-input oeko-search-input" style="border-radius:15px !important">
                <span class="oeko-search-leading" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </span>
                <input type="text" name="search" class="form-control"
                    placeholder="{{ d_trans('Search product or brand... e.g. Weleda, Nivea') }}" autocomplete="off">
                <button type="button" id="imageSearchBtn" class="oeko-camera-btn"
                    aria-label="{{ d_trans('Search by image') }}" title="{{ d_trans('Search by image') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                </button>
                <button aria-label="{{ d_trans('Search') }}" class="oeko-search-btn" type="submit">
                    <span class="search-btn-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </span>
                    <span class="search-btn-text">{{ d_trans('Search') }}</span>
                </button>
            </div>
        </form>
        <div class="search-results">
            <div class="search-results-inner" data-simplebar>
                <div></div>
            </div>
            <a href="{{ route('products.index') }}" class="search-action">
                {{ d_trans('View All Test Results') }}
            </a>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Premium Search Component Redesign */
        .oeko-hero-searchbar {
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
            overflow: visible;
        }

        .oeko-search-input {
            border-radius:15px !important;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.31);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 6px 8px 6px 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .oeko-search-input:hover {
            box-shadow: 
                0 24px 48px -12px rgba(74, 55, 40, 0.16),
                0 0 0 1px rgba(255, 255, 255, 0.9) inset,
                0 4px 12px rgba(74, 55, 40, 0.06);
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.31);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .oeko-search-input:focus-within {
            background: #FFFFFF;
            border-color: rgba(198, 40, 40, 0.25);
            box-shadow: 
                0 24px 50px -10px rgba(198, 40, 40, 0.15),
                0 0 0 4px rgba(198, 40, 40, 0.08),
                0 0 0 1px rgba(255, 255, 255, 1) inset;
            transform: translateY(-2px);
        }

        .oeko-search-leading {
            color: #A39384;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            transition: all 0.3s ease;
        }

        .oeko-search-input:focus-within .oeko-search-leading {
            color: #C62828;
            transform: scale(1.1) rotate(-5deg);
        }

        .oeko-search-input .form-control {
            flex: 1;
            border: none;
            background: transparent !important;
            font-family: 'DM Sans', 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 400;
            color: #2C1A0E !important;
            padding: 8px 0;
            box-shadow: none !important;
            outline: none;
            width: 100%;
            min-width: 0;
        }

        .oeko-search-input .form-control::placeholder {
            color: #B2A396 !important;
            font-weight: 400;
            transition: opacity 0.3s ease, color 0.3s ease;
        }

        .oeko-search-input:focus-within .form-control::placeholder {
            opacity: 0.6;
            color: #9C8878 !important;
        }

        .oeko-camera-btn {
            background: #FDFBF9;
            border: 1px solid #EAE0D6;
            color: #9C8878;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-right: 10px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            flex-shrink: 0;
        }

        .oeko-camera-btn:hover {
            background: #FFF5F5;
            border-color: #F8D7D7;
            color: #C62828;
            box-shadow: 0 4px 15px rgba(198, 40, 40, 0.12);
            transform: scale(1.08) translateY(-1px);
        }
        
        .oeko-camera-btn:active {
            transform: scale(0.95);
        }

        .oeko-search-btn {
            background: linear-gradient(135deg, #D32F2F 0%, #A91D1D 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0 24px;
            height: 44px;
            font-family: 'DM Sans', 'Inter', sans-serif;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(198, 40, 40, 0.35), inset 0 1px 0 rgba(255,255,255,0.25);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        /* Shine effect on the button */
        .oeko-search-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            transition: all 0.6s ease;
        }

        .oeko-search-btn:hover::after {
            left: 200%;
            transition: all 0.8s ease;
        }

        .oeko-search-btn:hover {
            box-shadow: 0 12px 30px rgba(198, 40, 40, 0.45), inset 0 1px 0 rgba(255,255,255,0.3);
            transform: translateY(-3px);
            background: linear-gradient(135deg, #E53935 0%, #B71C1C 100%);
        }
        
        .oeko-search-btn:active {
            transform: translateY(1px);
            box-shadow: 0 4px 12px rgba(198, 40, 40, 0.3);
        }

        .search-btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .oeko-search-btn:hover .search-btn-icon {
            transform: rotate(90deg) scale(1.15);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .oeko-hero-searchbar {
                padding: 0;
            }

            .oeko-search-input {
                padding: 4px 6px 4px 16px;
                border-radius: 14px;
            }

            .oeko-search-btn {
                width: 40px;
                height: 40px;
                padding: 0;
                border-radius: 10px;
                gap: 0;
            }
            
            .oeko-search-btn:hover .search-btn-icon {
                transform: scale(1.15); /* Disable rotation on mobile */
            }

            .search-btn-text {
                display: none;
            }
            
            .oeko-search-leading {
                margin-right: 8px;
            }
            
            .oeko-search-leading svg {
                width: 18px;
                height: 18px;
            }
            
            .oeko-search-input .form-control {
                font-size: 14px;
                padding: 10px 0;
            }
            
            .oeko-camera-btn {
                width: 36px;
                height: 36px;
                margin-right: 6px;
                border-radius: 8px;
            }
        }
    </style>
@endpush
