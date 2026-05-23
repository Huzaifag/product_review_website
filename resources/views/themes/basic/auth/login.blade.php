<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')

    <style>
        :root {
            --auth-primary: #C62828;
            --auth-primary-rgb: 198, 40, 40;
            --auth-ink: #1a1f36;
            --auth-muted: #6b7394;
            --auth-glow: rgba(198, 40, 40, .28);
        }

        html,
        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            background:
                radial-gradient(1200px 600px at 12% -10%, rgba(var(--auth-primary-rgb), .07) 0%, transparent 55%),
                radial-gradient(1000px 700px at 110% 110%, rgba(var(--auth-primary-rgb), .06) 0%, transparent 50%),
                linear-gradient(180deg, #fbfcff 0%, #f4f6fd 100%) !important;
        }

        /* ===== Animated background ===== */
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
            background: radial-gradient(circle at 30% 30%, #ff8a80, #C62828);
            animation-delay: -6s;
        }

        .auth-orb.c {
            width: 300px;
            height: 300px;
            left: 16%;
            bottom: -120px;
            background: radial-gradient(circle at 30% 30%, #ffcdd2, #8B0000);
            animation-delay: -11s;
        }

        @keyframes authFloat {
            0%,  100% { transform: translate(0, 0) scale(1); }
            33%        { transform: translate(40px, -30px) scale(1.08); }
            66%        { transform: translate(-30px, 25px) scale(.95); }
        }

        .auth-shape {
            position: absolute;
            opacity: .5;
            animation: authDrift 24s linear infinite;
        }

        .auth-shape.s1 { top: 14%; left: 8%;  animation-duration: 26s; }
        .auth-shape.s2 { top: 66%; left: 12%; animation-duration: 30s; animation-delay: -8s; }
        .auth-shape.s3 { top: 20%; right: 10%; animation-duration: 24s; animation-delay: -4s; }
        .auth-shape.s4 { top: 76%; right: 14%; animation-duration: 28s; animation-delay: -12s; }
        .auth-shape.s5 { top: 46%; left: 46%; animation-duration: 34s; animation-delay: -6s; }

        @keyframes authDrift {
            0%   { transform: translateY(0) rotate(0); }
            50%  { transform: translateY(-26px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
        }

        /* ===== Layout ===== */
        .sign {
            position: fixed !important;
            inset: 0 !important;
            z-index: 1000 !important;
            height: 100% !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            flex-direction: row !important;
            overflow: hidden !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        /* ===== Background slideshow ===== */
        .sign-bg-show {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .sign-bg-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            opacity: 0;
            z-index: 1;
            transition: opacity 2s cubic-bezier(.45, 0, .55, 1);
        }

        .sign-bg-slide.active {
            opacity: 1;
            z-index: 2;
        }

        .sign-bg-slide.leaving {
            opacity: 0;
            z-index: 2;
        }

        /* Left panel */
        .sign-left {
            flex: 0 0 50% !important;
            width: 50% !important;
            max-width: 50% !important;
            display: flex !important;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            overflow-y: auto;
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, .55);
            backdrop-filter: blur(18px) saturate(140%);
            -webkit-backdrop-filter: blur(18px) saturate(140%);
        }

        /* Right panel */
        .sign-right {
            flex: 0 0 50% !important;
            width: 50% !important;
            max-width: 50% !important;
            position: relative;
            overflow: hidden;
            z-index: 1;
            background: transparent;
        }

        .sign-right-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .55) 0%, rgba(0, 0, 0, .25) 50%, rgba(0, 0, 0, .15) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            text-align: center;
            color: #fff;
        }

        .sign-right-overlay p {
            font-size: 1.5rem;
            opacity: .9;
            text-shadow: 0 1px 6px rgba(0, 0, 0, .3);
            margin-bottom: 0;
        }

        /* Mobile */
        @media (max-width: 767px) {
            html, body { height: auto !important; overflow: auto !important; }
            .sign { position: relative !important; inset: auto !important; flex-direction: column !important; height: auto !important; min-height: 100vh !important; overflow: visible !important; }
            .sign-left { flex: none !important; width: 100% !important; max-width: none !important; padding: 32px 20px !important; min-height: 100vh !important; overflow-y: auto !important; align-items: center !important; }
            .sign-right { display: none !important; }
            .sign-body .logo { justify-content: center !important; display: flex !important; width: 100% !important; }
        }

        /* Sign body */
        .sign-body {
            width: 100%;
            max-width: 440px;
            animation: authRise .7s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes authRise {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: none; }
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

        /* Sign box */
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

        .auth-head { text-align: start; }

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

        /* Inputs */
        .input-icon-wrap { position: relative; }

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

        .form-control.has-icon { padding-inline-start: 44px; }

        .input-icon-wrap:focus-within .input-icon { color: var(--auth-primary); }

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

        .toggle-pass:hover { color: var(--auth-primary); }

        .auth-link {
            font-weight: 600;
            text-decoration: none;
            color: var(--auth-primary);
        }

        .auth-link:hover { text-decoration: underline; }

        /* Button */
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
            background: var(--auth-primary);
            border-color: var(--auth-primary);
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
            background: #a31e1e;
            border-color: #a31e1e;
        }

        .btn-auth:hover::after { inset-inline-start: 130%; }
        .btn-auth:active { transform: translateY(0); }

        .btn-auth i { transition: transform .2s; }
        .btn-auth:hover i { transform: translateX(3px); }
        html[dir="rtl"] .btn-auth:hover i { transform: translateX(-3px); }

        /* Staggered reveal */
        .field-anim {
            animation: authRise .6s cubic-bezier(.22, 1, .36, 1) both;
            animation-delay: var(--d, 0s);
        }

        /* ===== Tagline animation ===== */
        .tagline-text {
            background: linear-gradient(
                100deg,
                rgba(255, 255, 255, .92) 0%,
                rgba(255, 255, 255, .92) 30%,
                rgba(255, 255, 255, 1)   48%,
                rgba(255, 255, 255, 1)   52%,
                rgba(255, 255, 255, .92) 70%,
                rgba(255, 255, 255, .92) 100%
            );
            background-size: 250% auto;
            background-position: 200% center;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, .6));
            animation:
                taglineRise   .9s cubic-bezier(.22, 1, .36, 1) .4s both,
                taglineShimmer 3.6s ease-in-out 1.8s infinite;
            transition: opacity .35s;
        }

        @keyframes taglineRise {
            from { opacity: 0; transform: translateY(18px); letter-spacing: .06em; }
            to   { opacity: 1; transform: none; letter-spacing: normal; }
        }

        @keyframes taglineShimmer {
            0%   { background-position:  200% center; }
            50%  { background-position: -200% center; }
            100% { background-position: -200% center; }
        }

        /* ===== Back to home button ===== */
        .btn-back-home {
            position: absolute;
            top: 22px;
            inset-inline-start: 24px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 14px 7px 10px;
            border-radius: 10px;
            border: 1.5px solid rgba(var(--auth-primary-rgb), .18);
            background: rgba(var(--auth-primary-rgb), .05);
            color: var(--auth-primary);
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: .01em;
            transition: background .2s, border-color .2s, transform .2s;
            z-index: 10;
        }

        .btn-back-home:hover {
            background: rgba(var(--auth-primary-rgb), .12);
            border-color: rgba(var(--auth-primary-rgb), .40);
            color: var(--auth-primary);
            transform: translateX(-3px);
        }

        html[dir="rtl"] .btn-back-home:hover { transform: translateX(3px); }

        .btn-back-home i { font-size: .95rem; }

        /* ===== Right footer ===== */
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

        /* ===== Glass language picker ===== */
        .lang-picker { position: relative; }

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
            box-shadow: 0 1px 4px rgba(0, 0, 0, .25);
        }

        .lang-picker-btn .chevron-icon {
            font-size: .72rem;
            opacity: .8;
            transition: transform .25s;
            margin-inline-start: 2px;
        }

        .lang-picker.open .lang-picker-btn .chevron-icon { transform: rotate(180deg); }

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

        .lang-picker-item:hover { background: rgba(255, 255, 255, .1); color: #fff; }

        .lang-picker-item.active {
            background: rgba(var(--auth-primary-rgb), .3);
            color: #fff;
            font-weight: 700;
        }

        .lang-picker-item .flag-img {
            width: 22px;
            height: 15px;
            border-radius: 3px;
            object-fit: cover;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .3);
        }

        /* ===== Credit block ===== */
        .sign-right-credit { text-align: right; }

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
            background: linear-gradient(90deg, #c084fc 0%, #818cf8 45%, #38bdf8 100%);
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

        @media (prefers-reduced-motion: reduce) {
            .auth-orb, .auth-shape, .field-anim, .sign-body { animation: none !important; }
            .tagline-text { animation: none !important; -webkit-text-fill-color: rgba(255, 255, 255, .9); }
        }
    </style>
</head>

<body>
    {{-- Animated background --}}
    <div class="auth-grid"></div>
    <div class="auth-bg" aria-hidden="true">
        <div class="auth-orb a"></div>
        <div class="auth-orb b"></div>
        <div class="auth-orb c"></div>
        <div class="auth-shape s1"><svg width="60" height="60" viewBox="0 0 60 60">
                <rect x="6" y="6" width="48" height="48" rx="12" fill="none" stroke="var(--auth-primary)" stroke-width="2" opacity=".6" />
            </svg></div>
        <div class="auth-shape s2"><svg width="46" height="46" viewBox="0 0 46 46">
                <circle cx="23" cy="23" r="20" fill="none" stroke="#C62828" stroke-width="2" opacity=".55" />
            </svg></div>
        <div class="auth-shape s3"><svg width="54" height="54" viewBox="0 0 54 54">
                <polygon points="27,4 50,46 4,46" fill="none" stroke="#8B0000" stroke-width="2" opacity=".55" />
            </svg></div>
        <div class="auth-shape s4"><svg width="40" height="40" viewBox="0 0 40 40">
                <rect x="8" y="8" width="24" height="24" rx="6" fill="var(--auth-primary)" opacity=".3" />
            </svg></div>
        <div class="auth-shape s5"><svg width="50" height="50" viewBox="0 0 50 50">
                <path d="M25 4 L46 25 L25 46 L4 25 Z" fill="none" stroke="#C62828" stroke-width="2" opacity=".5" />
            </svg></div>
    </div>

    <div class="sign">
        <div class="sign-bg-show" aria-hidden="true">
            <img class="sign-bg-slide active" src="{{ asset('images/auth-cover.jpg') }}" alt="">
            <img class="sign-bg-slide" src="{{ asset('images/auth-cover-1.webp') }}" alt="">
            <img class="sign-bg-slide" src="{{ asset('images/auth-cover-2.jpeg') }}" alt="">
        </div>

        {{-- Left: form panel --}}
        <div class="sign-left">
            <a href="{{ url('/') }}" class="btn-back-home">
                <i class="bi bi-arrow-left"></i>
                {{ d_trans('Back to Home') }}
            </a>
            <div class="sign-body">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset(config('theme.settings.general.logo_light')) }}"
                        alt="{{ m_trans(config('settings.general.site_name')) }}">
                </a>
                <div class="sign-box">
                    <div class="auth-head mb-4">
                        <span class="auth-badge">
                            <i class="bi bi-person-circle"></i>
                            {{ d_trans('Welcome Back') }}
                        </span>
                        <h2>{{ d_trans('Sign In') }} </h2>
                        <p class="text-muted mb-0" style="font-size:.9rem;">{{ d_trans('Enter your account details to sign in') }}</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3 field-anim input-icon-wrap" style="--d:.05s">
                            <span class="input-icon"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="email_or_username" class="form-control has-icon"
                                placeholder="{{ d_trans('Email or Username') }}"
                                value="{{ old('email_or_username') }}" autocomplete="off" required />
                        </div>
                        <div class="mb-3 field-anim input-icon-wrap" style="--d:.10s">
                            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password" id="lp-pass" class="form-control has-icon"
                                placeholder="{{ d_trans('Password') }}" style="padding-inline-end:44px;" required />
                            <button type="button" class="toggle-pass" onclick="lpTogglePass()"
                                aria-label="{{ d_trans('Toggle password visibility') }}">
                                <i class="bi bi-eye" id="lp-eye-icon"></i>
                            </button>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3 field-anim" style="--d:.15s">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">{{ d_trans('Remember Me') }}</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="auth-link small">{{ d_trans('Forgot Password?') }}</a>
                        </div>

                        <div class="field-anim" style="--d:.18s">
                            <x-captcha />
                        </div>

                        <div class="field-anim" style="--d:.22s">
                            <button type="submit" class="btn btn-primary btn-auth w-100">
                                {{ d_trans('Sign In') }} <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>

                    <x-oauth-buttons />

                    @if (config('settings.user.actions.registration'))
                        <p class="text-center text-muted small mt-3 mb-0">
                            {{ d_trans("Don't have an account?") }}
                            <a href="{{ route('register') }}" class="auth-link">{{ d_trans('Sign Up') }}</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: transparent panel — image shows through --}}
        <div class="sign-right">
            <div class="sign-right-overlay">
                <img src="{{ asset('images/oko-logo.png') }}" alt="{{ m_trans(config('settings.general.site_name')) }}" height="130">
                <p class="tagline-text" id="rp-tagline">{{ d_trans('Discover beauty,') }}<br>{{ d_trans('test before you glow') }}</p>
            </div>

            {{-- Language picker + credit --}}
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

    @include('themes.basic.includes.scripts')

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
    @elseif(session('resent'))
        <script>
            toastr.success('{{ d_trans('Link has been resend Successfully') }}')
        </script>
    @endif

    <script>
        /* Background slideshow + synced taglines */
        (function () {
            const slides = document.querySelectorAll('.sign-bg-slide');
            const taglines = [
                'Discover beauty,<br>test before you glow',
                'Know what\'s really<br>inside your cosmetics',
                'The truth your<br>label won\'t tell you',
                'Independent labs,<br>honest verdicts'
            ];
            const taglineEl = document.getElementById('rp-tagline');
            if (!slides.length) return;
            let current = 0;

            setInterval(function () {
                const outgoing = slides[current];
                current = (current + 1) % slides.length;
                const incoming = slides[current];

                incoming.style.zIndex = '1';
                incoming.style.opacity = '1';
                outgoing.style.zIndex = '2';
                outgoing.style.opacity = '0';

                setTimeout(function () {
                    outgoing.classList.remove('active');
                    outgoing.style.zIndex = '';
                    outgoing.style.opacity = '';
                    incoming.classList.add('active');
                    incoming.style.zIndex = '';
                    incoming.style.opacity = '';
                }, 2000);

                if (taglineEl) {
                    taglineEl.style.opacity = '0';
                    setTimeout(function () {
                        taglineEl.innerHTML = taglines[current % taglines.length];
                        taglineEl.style.opacity = '1';
                    }, 350);
                }
            }, 4500);
        })();

        /* Year */
        document.querySelectorAll('[data-year]').forEach(function(el) {
            el.textContent = new Date().getFullYear();
        });

        /* Language picker */
        (function() {
            const picker = document.getElementById('authLangPicker');
            if (!picker) return;
            const btn = picker.querySelector('.lang-picker-btn');
            function close() { picker.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); }
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = picker.classList.toggle('open');
                btn.setAttribute('aria-expanded', isOpen);
            });
            document.addEventListener('click', close);
            document.addEventListener('keydown', function(e) { if (e.key === 'Escape') close(); });
        })();

        /* Password toggle */
        window.lpTogglePass = function() {
            var inp = document.getElementById('lp-pass');
            var icon = document.getElementById('lp-eye-icon');
            inp.type = inp.type === 'password' ? 'text' : 'password';
            icon.className = inp.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        };
    </script>
</body>

</html>
