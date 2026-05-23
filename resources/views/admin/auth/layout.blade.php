<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('admin.includes.head')

    {{-- Premium auth styling. Uses your existing theme primary color via Bootstrap's --bs-primary. --}}
    <style>
        :root {
            --auth-primary: var(--bs-primary, #4c6ef5);
            --auth-primary-rgb: var(--bs-primary-rgb, 76, 110, 245);
            --auth-ink: var(--bs-body-color, #1a1f36);
            --auth-muted: var(--bs-secondary-color, #6b7394);
            --auth-glow: rgba(var(--auth-primary-rgb), .30);
        }

        html,
        body.bg-white {
            height: 100vh;
            overflow: hidden;
            background:
                radial-gradient(1200px 600px at 12% -10%, rgba(var(--auth-primary-rgb), .10) 0%, transparent 55%),
                radial-gradient(1000px 700px at 110% 110%, rgba(var(--auth-primary-rgb), .08) 0%, transparent 50%),
                linear-gradient(180deg, #fbfcff 0%, #f4f6fd 100%) !important;
        }

        /* ===== Animated background layers ===== */
        .auth-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .auth-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: .4;
            background-image:
                linear-gradient(rgba(var(--auth-primary-rgb), .05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(var(--auth-primary-rgb), .05) 1px, transparent 1px);
            background-size: 48px 48px;
            -webkit-mask-image: radial-gradient(ellipse at center, #000 30%, transparent 75%);
            mask-image: radial-gradient(ellipse at center, #000 30%, transparent 75%);
        }

        .auth-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(45px);
            opacity: .5;
            animation: authFloat 18s ease-in-out infinite;
        }

        .auth-orb.a {
            width: 420px;
            height: 420px;
            left: -120px;
            top: -80px;
            background: radial-gradient(circle at 30% 30%, rgba(var(--auth-primary-rgb), .9), rgba(var(--auth-primary-rgb), .55));
        }

        .auth-orb.b {
            width: 360px;
            height: 360px;
            right: -100px;
            top: 18%;
            background: radial-gradient(circle at 30% 30%, #b692ff, #5f3dc4);
            animation-delay: -6s;
        }

        .auth-orb.c {
            width: 300px;
            height: 300px;
            left: 16%;
            bottom: -120px;
            background: radial-gradient(circle at 30% 30%, #74e0ff, #3ba9d8);
            animation-delay: -11s;
        }

        @keyframes authFloat {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(40px, -30px) scale(1.08);
            }

            66% {
                transform: translate(-30px, 25px) scale(.95);
            }
        }

        .auth-shape {
            position: absolute;
            opacity: .5;
            animation: authDrift 24s linear infinite;
        }

        .auth-shape.s1 {
            top: 14%;
            left: 8%;
            animation-duration: 26s;
        }

        .auth-shape.s2 {
            top: 66%;
            left: 12%;
            animation-duration: 30s;
            animation-delay: -8s;
        }

        .auth-shape.s3 {
            top: 20%;
            right: 10%;
            animation-duration: 24s;
            animation-delay: -4s;
        }

        .auth-shape.s4 {
            top: 76%;
            right: 14%;
            animation-duration: 28s;
            animation-delay: -12s;
        }

        .auth-shape.s5 {
            top: 46%;
            left: 46%;
            animation-duration: 34s;
            animation-delay: -6s;
        }

        @keyframes authDrift {
            0% {
                transform: translateY(0) rotate(0);
            }

            50% {
                transform: translateY(-26px) rotate(180deg);
            }

            100% {
                transform: translateY(0) rotate(360deg);
            }
        }

        /* ===== Layout / two-panel split ===== */
        .sign {
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            flex-direction: row;
            width: 100%;
            overflow: hidden;
        }

        /* Full-bleed background image behind both panels */
        .sign-bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: 0;
            display: block;
        }

        /* Left panel – frosted overlay so image subtly shows through */
        .sign-left {
            flex: 0 0 50%;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, .55);
            backdrop-filter: blur(18px) saturate(140%);
            -webkit-backdrop-filter: blur(18px) saturate(140%);
        }

        /* Right panel – fully transparent so image is crystal clear */
        .sign-right {
            flex: 0 0 50%;
            width: 50%;
            position: relative;
            overflow: hidden;
            z-index: 1;
            background: transparent;
        }

        .sign-right-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .45) 0%, transparent 55%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            text-align: center;
            color: #fff;
        }

        .sign-right-overlay h2 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -.02em;
            margin-bottom: 12px;
            text-shadow: 0 2px 12px rgba(0, 0, 0, .35);
        }

        .sign-right-overlay p {
            font-size: 1.5rem;
            opacity: .9;
            /* max-width: 340px; */
            text-shadow: 0 1px 6px rgba(0, 0, 0, .3);
            margin-bottom: 0;
        }

        /* ===== Tagline animation ===== */
        .tagline-text {
            background: linear-gradient(
                100deg,
                rgba(255, 255, 255, .70) 0%,
                rgba(255, 255, 255, .70) 30%,
                rgba(255, 255, 255, 1)   48%,
                rgba(255, 255, 255, 1)   52%,
                rgba(255, 255, 255, .70) 70%,
                rgba(255, 255, 255, .70) 100%
            );
            background-size: 250% auto;
            background-position: 200% center;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation:
                taglineRise   .9s cubic-bezier(.22, 1, .36, 1) .4s both,
                taglineShimmer 3.6s ease-in-out 1.8s infinite;
        }

        @keyframes taglineRise {
            from {
                opacity: 0;
                transform: translateY(18px);
                letter-spacing: .06em;
            }
            to {
                opacity: 1;
                transform: none;
                letter-spacing: normal;
            }
        }

        @keyframes taglineShimmer {
            0%   { background-position:  200% center; }
            50%  { background-position: -200% center; }
            100% { background-position: -200% center; }
        }

        @media (prefers-reduced-motion: reduce) {
            .tagline-text {
                animation: none !important;
                -webkit-text-fill-color: rgba(255, 255, 255, .9);
            }
        }

        .sign-body {
            width: 100%;
            max-width: 440px;
            animation: authRise .7s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes authRise {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .sign-body .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 22px;
        }

        .sign-body .logo img {
            height: 44px;
            width: auto;
        }

        /* Mobile – stack, hide image panel */
        @media (max-width: 767px) {

            html,
            body.bg-white {
                height: auto;
                overflow: auto;
            }

            .sign {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }

            .sign-left {
                flex: none;
                width: 100%;
                max-width: none;
                padding: 32px 20px;
                min-height: 100vh;
                overflow-y: auto;
            }

            .sign-right {
                display: none;
            }
        }

        .sign-box {
            position: relative;
            background: rgba(255, 255, 255, .72);
            backdrop-filter: blur(22px) saturate(160%);
            -webkit-backdrop-filter: blur(22px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 24px;
            padding: 38px 36px 34px;
            box-shadow:
                0 30px 70px -25px rgba(31, 41, 80, .35),
                0 4px 14px rgba(31, 41, 80, .06),
                inset 0 1px 0 rgba(255, 255, 255, .8);
        }

        .sign-box::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 1px;
            pointer-events: none;
            background: linear-gradient(135deg, var(--auth-glow), rgba(var(--auth-primary-rgb), .1) 40%, transparent 70%);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .auth-head {
            text-align: start;
        }

        .auth-head h2 {
            font-size: 1.7rem;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 14px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--auth-primary);
            background: rgba(var(--auth-primary-rgb), .1);
        }

        /* ===== Inputs ===== */
        .input-icon-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            inset-inline-start: 15px;
            color: var(--auth-muted);
            font-size: 1.05rem;
            pointer-events: none;
            transition: color .25s;
            z-index: 2;
        }

        .form-control.has-icon {
            padding-inline-start: 44px;
        }

        .input-icon-wrap:focus-within .input-icon {
            color: var(--auth-primary);
        }

        .sign-box .form-control {
            border: 1.5px solid var(--bs-border-color, #e7e9f3);
            border-radius: 13px;
            transition: .25s;
        }

        .sign-box .form-control:focus {
            border-color: var(--auth-primary);
            background: #fff;
            box-shadow: 0 0 0 4px var(--auth-glow);
        }

        .toggle-pass {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            inset-inline-end: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--auth-muted);
            font-size: 1.05rem;
            padding: 4px;
            line-height: 0;
            transition: color .2s;
            z-index: 2;
        }

        .toggle-pass:hover {
            color: var(--auth-primary);
        }

        .auth-link {
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        /* ===== Button ===== */
        .btn-auth {
            position: relative;
            overflow: hidden;
            font-weight: 700;
            padding: 13px;
            border-radius: 13px;
            box-shadow: 0 14px 30px -8px var(--auth-glow);
            transition: transform .2s, box-shadow .2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-auth::after {
            content: "";
            position: absolute;
            top: 0;
            inset-inline-start: -120%;
            width: 60%;
            height: 100%;
            transform: skewX(-20deg);
            transition: .6s;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .35), transparent);
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -10px var(--auth-glow);
        }

        .btn-auth:hover::after {
            inset-inline-start: 130%;
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .btn-auth i {
            transition: transform .2s;
        }

        .btn-auth:hover i {
            transform: translateX(3px);
        }

        html[dir="rtl"] .btn-auth:hover i {
            transform: translateX(-3px);
        }

        /* ===== Staggered field reveal ===== */
        .field-anim {
            animation: authRise .6s cubic-bezier(.22, 1, .36, 1) both;
            animation-delay: var(--d, 0s);
        }

        @media (prefers-reduced-motion: reduce) {

            .auth-orb,
            .auth-shape,
            .field-anim,
            .sign-body {
                animation: none !important;
            }
        }

        /* ===== Right-panel footer (language + copyright) ===== */
        .sign-right-footer {
            position: absolute;
            bottom: 28px;
            right: 32px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
            z-index: 10;
        }

        /* ===== Modern glass language picker ===== */
        .lang-picker {
            position: relative;
        }

        .lang-picker-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .30);
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            color: #fff;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, border-color .2s, box-shadow .2s;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .18);
            white-space: nowrap;
            letter-spacing: .01em;
        }

        .lang-picker-btn:hover {
            background: rgba(255, 255, 255, .22);
            border-color: rgba(255, 255, 255, .55);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .25);
        }

        .lang-picker-btn .flag-img {
            width: 20px;
            height: 14px;
            border-radius: 3px;
            object-fit: cover;
            box-shadow: 0 1px 4px rgba(0,0,0,.25);
        }

        .lang-picker-btn .chevron-icon {
            font-size: .72rem;
            opacity: .8;
            transition: transform .25s;
            margin-inline-start: 2px;
        }

        .lang-picker.open .lang-picker-btn .chevron-icon {
            transform: rotate(180deg);
        }

        .lang-picker-menu {
            position: absolute;
            bottom: calc(100% + 10px);
            right: 0;
            min-width: 180px;
            background: rgba(20, 22, 40, .82);
            backdrop-filter: blur(22px) saturate(180%);
            -webkit-backdrop-filter: blur(22px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 16px;
            padding: 6px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, .45),
                0 2px 8px rgba(0, 0, 0, .2),
                inset 0 1px 0 rgba(255, 255, 255, .08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px) scale(.97);
            transform-origin: bottom right;
            transition: opacity .22s, transform .22s, visibility .22s;
            z-index: 999;
        }

        .lang-picker.open .lang-picker-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .lang-picker-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            color: rgba(255, 255, 255, .85);
            font-size: .83rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .18s, color .18s;
            white-space: nowrap;
        }

        .lang-picker-item:hover {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        .lang-picker-item.active {
            background: rgba(var(--auth-primary-rgb), .25);
            color: #fff;
            font-weight: 700;
        }

        .lang-picker-item .flag-img {
            width: 22px;
            height: 15px;
            border-radius: 3px;
            object-fit: cover;
            box-shadow: 0 1px 4px rgba(0,0,0,.3);
        }

        /* ===== Right-panel credit block ===== */
        .sign-right-credit {
            text-align: right;
        }

        .src-divider {
            height: 1px;
            background: linear-gradient(to left, rgba(255, 255, 255, .40), rgba(255, 255, 255, .04));
            margin-bottom: 10px;
        }

        .src-dev {
            display: block;
            font-size: .78rem;
            font-weight: 500;
            color: rgba(255, 255, 255, .55);
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-bottom: 5px;
        }

        .src-brand {
            background: linear-gradient(90deg, #eb0505 0%, #662c1d 45%, #b10707 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: .05em;
            font-style: italic;
        }

        .src-copy {
            font-size: .88rem;
            color: rgba(255, 255, 255, .6);
            letter-spacing: .015em;
            line-height: 1.5;
        }
    </style>
</head>

<body class="bg-white">
    {{-- Animated background --}}
    <div class="auth-grid"></div>
    <div class="auth-bg" aria-hidden="true">
        <div class="auth-orb a"></div>
        <div class="auth-orb b"></div>
        <div class="auth-orb c"></div>
        <div class="auth-shape s1"><svg width="60" height="60" viewBox="0 0 60 60">
                <rect x="6" y="6" width="48" height="48" rx="12" fill="none"
                    stroke="var(--auth-primary)" stroke-width="2" opacity=".6" />
            </svg></div>
        <div class="auth-shape s2"><svg width="46" height="46" viewBox="0 0 46 46">
                <circle cx="23" cy="23" r="20" fill="none" stroke="#5f3dc4" stroke-width="2"
                    opacity=".55" />
            </svg></div>
        <div class="auth-shape s3"><svg width="54" height="54" viewBox="0 0 54 54">
                <polygon points="27,4 50,46 4,46" fill="none" stroke="#3ba9d8" stroke-width="2" opacity=".55" />
            </svg></div>
        <div class="auth-shape s4"><svg width="40" height="40" viewBox="0 0 40 40">
                <rect x="8" y="8" width="24" height="24" rx="6" fill="var(--auth-primary)"
                    opacity=".3" />
            </svg></div>
        <div class="auth-shape s5"><svg width="50" height="50" viewBox="0 0 50 50">
                <path d="M25 4 L46 25 L25 46 L4 25 Z" fill="none" stroke="#5f3dc4" stroke-width="2" opacity=".5" />
            </svg></div>
    </div>

    <div class="sign">
        {{-- Full-bleed background image shared by both panels --}}
        <img class="sign-bg-img" src="{{ asset('images/auth-cover.jpg') }}" alt="">

        {{-- Left: form panel --}}
        <div class="sign-left">
            <div class="sign-body">
                <a href="{{ route('admin.index') }}" class="logo">
                    <img src="{{ asset(config('theme.settings.general.logo_dark')) }}"
                        alt="{{ m_trans(config('settings.general.site_name')) }}">
                </a>
                <div class="sign-box">
                    @yield('content')
                </div>
            </div>
        </div>

        {{-- Right: transparent panel — image shows through from .sign-bg-img --}}
        <div class="sign-right">
            <div class="sign-right-overlay">
                <img src="{{ asset('images/oko-logo.png') }}" alt="{{ m_trans(config('settings.general.site_name')) }}" height="130">

                {{-- <h2>{{ m_trans(config('settings.general.site_name')) }}</h2> --}}
                <p>{{ d_trans('Manage your platform with confidence.') }}</p>
            </div>

            {{-- Language picker + copyright pinned to bottom-right --}}
            @php $languages = languages(); $currentLanguage = languages(getLocale()); @endphp
            <div class="sign-right-footer">
                @if ($languages->count() > 1)
                <div class="lang-picker" id="authLangPicker">
                    <button class="lang-picker-btn" type="button" aria-haspopup="true" aria-expanded="false">
                        <img class="flag-img" src="{{ $currentLanguage->getLogoLink() }}" alt="{{ $currentLanguage->trans->name }}">
                        <span>{{ $currentLanguage->trans->name }}</span>
                        <i class="bi bi-chevron-down chevron-icon"></i>
                    </button>
                    <div class="lang-picker-menu" role="menu">
                        @foreach ($languages as $navLanguage)
                            <a href="{{ $navLanguage->getLocalizeUrl() }}"
                               class="lang-picker-item {{ $navLanguage->code == getLocale() ? 'active' : '' }}"
                               role="menuitem">
                                <img class="flag-img" src="{{ $navLanguage->getLogoLink() }}" alt="{{ $navLanguage->trans->name }}">
                                <span>{{ $navLanguage->trans->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="sign-right-credit">
                    <div class="src-divider"></div>
                    <span class="src-dev">{{ d_trans('Developed by') }} <strong class="src-brand">Bitlogicx</strong></span>
                    <p class="src-copy mb-0">
                        &copy; <span data-year></span>
                        {{ m_trans(config('settings.general.site_name')) }} &mdash; {{ d_trans('All rights reserved') }}.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('admin.includes.scripts')
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        </script>
    @elseif(session('status'))
        <script>
            toastr.success('{{ session('status') }}')
        </script>
    @endif

    <script>
        (function () {
            const picker = document.getElementById('authLangPicker');
            if (!picker) return;
            const btn = picker.querySelector('.lang-picker-btn');
            function close() {
                picker.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
            }
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isOpen = picker.classList.toggle('open');
                btn.setAttribute('aria-expanded', isOpen);
            });
            document.addEventListener('click', close);
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') close();
            });
        })();
    </script>
</body>

</html>
