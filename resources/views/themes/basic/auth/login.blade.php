@extends('themes.basic.auth.layout')
@section('title', d_trans('Sign In'))

@push('styles_libs')
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

@push('styles')
    <style>
        .sign {
            max-width: none !important;
            padding: 0 !important;
        }

        .section-body {
            display: flex;
            justify-content: center;
        }

        .login-wrap {
            display: flex;
            width: 100%;
            max-width: 1020px;
            min-height: 480px;
            border-radius: 18px;
            overflow: hidden;
            border: 0.5px solid #e0e0e0;
            box-shadow: 0 8px 40px rgba(198, 40, 40, 0.08);
            background: #fff;
        }

        .lp-left {
            flex: 1;
            padding: 2.5rem 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .lp-right {
            flex: 1;
            background: linear-gradient(135deg, #C62828 0%, #8B0000 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .lp-right {
                display: none;
            }

            .lp-left {
                padding: 2rem 1.5rem;
            }
        }

        .lp-brand {
            display: inline-block;
            margin-bottom: 1.6rem;
        }

        .lp-brand img {
            height: 40px;
            width: auto;
            display: block;
        }

        .lp-title {
            font-size: 22px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .lp-subtitle {
            font-size: 13px;
            color: #888;
            margin-bottom: 1.8rem;
            line-height: 1.5;
        }

        .lp-field {
            margin-bottom: 1rem;
            position: relative;
        }

        .lp-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 13px;
            color: #333;
            background: #fafafa;
            outline: none;
            transition: border 0.2s;
            box-shadow: none;
        }

        .lp-input:focus {
            border-color: #C62828 !important;
            background: #fff;
            box-shadow: none !important;
        }

        .lp-input::placeholder {
            color: #bbb;
        }

        .lp-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #bbb;
            font-size: 17px;
            padding: 0;
            line-height: 1;
        }

        .lp-eye:hover {
            color: #C62828;
        }

        .lp-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 12px;
        }

        .lp-meta .form-check {
            margin: 0;
        }

        .lp-meta .form-check-input {
            width: 14px;
            height: 14px;
        }

        .lp-meta .form-check-label {
            font-size: 12px;
            color: #888;
        }

        .lp-meta a {
            color: #C62828;
            text-decoration: none;
            font-weight: 500;
            font-size: 12px;
        }

        .lp-meta a:hover {
            text-decoration: underline;
        }

        .lp-submit {
            width: 100%;
            background: #C62828;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 11px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-bottom: 0.25rem;
        }

        .lp-submit:hover {
            background: #a31e1e;
            transform: translateY(-1px);
        }

        .lp-submit:active {
            transform: scale(0.98);
        }

        /* OAuth component overrides */
        .login-wrap .login-with {
            margin-top: 0.5rem;
        }

        .login-wrap .login-with-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0.8rem;
            font-size: 12px;
            color: #bbb;
        }

        .login-wrap .login-with-divider::before,
        .login-wrap .login-with-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ebebeb;
        }

        .login-wrap .login-with-divider span {
            background: none;
            padding: 0;
        }

        .login-wrap .btn-social {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px;
            border: 1px solid #e0e0e0 !important;
            border-radius: 10px !important;
            padding: 9px 12px !important;
            background: #fff !important;
            font-size: 13px !important;
            color: #333 !important;
            transition: border 0.2s, background 0.2s;
        }

        .login-wrap .btn-social:hover {
            border-color: #C62828 !important;
            background: #fff5f5 !important;
            color: #333 !important;
        }

        .lp-signup {
            font-size: 12px;
            color: #999;
            margin-top: 0.8rem;
        }

        .lp-signup a {
            color: #C62828;
            text-decoration: none;
            font-weight: 500;
        }

        .lp-signup a:hover {
            text-decoration: underline;
        }

        /* Right panel */
        .rp-tagline {
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            text-align: center;
            line-height: 1.4;
            margin-bottom: 1.2rem;
            z-index: 2;
            transition: opacity 0.4s;
        }

        .rp-slides {
            width: 260px;
            height: 230px;
            border-radius: 18px;
            overflow: hidden;
            position: relative;
            z-index: 2;
            margin-bottom: 1.2rem;
            background: rgba(255, 255, 255, 0.1);
        }

        .rp-track {
            display: flex;
            width: 300%;
            height: 100%;
            transition: transform 0.6s cubic-bezier(.77, 0, .18, 1);
        }

        .rp-slide {
            width: 33.33%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .rp-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
        }

        .rp-slide:hover img {
            transform: scale(1.04);
        }

        .rp-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(139, 0, 0, 0.82));
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            padding: 28px 12px 10px;
            text-align: center;
        }

        .rp-overlay {
            position: absolute;
            inset: 0;
            background: rgba(198, 40, 40, 0.15);
            pointer-events: none;
        }

        .rp-dots {
            display: flex;
            gap: 7px;
            z-index: 2;
        }

        .rp-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .rp-dot.active {
            background: #fff;
            transform: scale(1.2);
        }

        .rp-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .rp-circle-1 {
            width: 220px;
            height: 220px;
            bottom: -60px;
            right: -60px;
        }

        .rp-circle-2 {
            width: 140px;
            height: 140px;
            top: -40px;
            left: -40px;
        }

        /* Entry animations */
        .lp-left>* {
            animation: lpUp 0.5s ease both;
        }

        .lp-left>*:nth-child(2) {
            animation-delay: 0.05s;
        }

        .lp-left>*:nth-child(3) {
            animation-delay: 0.10s;
        }

        .lp-left>*:nth-child(4) {
            animation-delay: 0.15s;
        }

        .lp-left>*:nth-child(5) {
            animation-delay: 0.20s;
        }

        .lp-left>*:nth-child(6) {
            animation-delay: 0.25s;
        }

        .lp-left>*:nth-child(7) {
            animation-delay: 0.30s;
        }

        @keyframes lpUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .wave {
            /* animation: wave 2s infinite; */
            transform-origin: 70% 70%;
            display: inline-block;
        }

        /* @keyframes wave {
                0% {
                    transform: rotate(0deg);
                }

                25% {
                    transform: rotate(-10deg);
                }

                50% {
                    transform: rotate(10deg);
                }

                75% {
                    transform: rotate(-10deg);
                }

                100% {
                    transform: rotate(0deg);
                }
            } */
    </style>
@endpush

@section('content')
    <div class="login-wrap">

        {{-- Left: login form --}}
        <div class="lp-left">
            <a href="{{ url('/') }}" class="lp-brand">
                <img src="{{ asset(config('theme.settings.general.logo_light')) }}"
                    alt="{{ m_trans(config('settings.general.site_name')) }}" />
            </a>

            <div class="lp-title">{{ d_trans('Sign In') }}
                <img src="{{ asset('images/frontend/hello.png') }}" alt="Hello" class="wave"
                    style="width:24px; height:24px; margin-left:6px;" />
            </div>
            <div class="lp-subtitle">{{ d_trans('Enter your account details to sign in') }}</div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="lp-field">
                    <input type="text" name="email_or_username" class="lp-input"
                        placeholder="{{ d_trans('Email or Username') }}" value="{{ old('email_or_username') }}"
                        autocomplete="off" required />
                </div>
                <div class="lp-field">
                    <input type="password" name="password" id="lp-pass" class="lp-input"
                        placeholder="{{ d_trans('Password') }}" style="padding-right:38px;" required />
                    <button type="button" class="lp-eye" onclick="lpTogglePass()"
                        aria-label="{{ d_trans('Toggle password visibility') }}">
                        <i class="ti ti-eye" id="lp-eye-icon"></i>
                    </button>
                </div>

                <div class="lp-meta">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ d_trans('Remember Me') }}</label>
                    </div>
                    <a href="{{ route('password.request') }}">{{ d_trans('Forgot Password?') }}</a>
                </div>

                <x-captcha />
                <button type="submit" class="lp-submit">{{ d_trans('Sign In') }}</button>
            </form>

            <x-oauth-buttons />

            @if (config('settings.user.actions.registration'))
                <div class="lp-signup">
                    {{ d_trans("Don't have an account?") }} <a
                        href="{{ route('register') }}">{{ d_trans('Sign Up') }}</a>
                </div>
            @endif
        </div>

        {{-- Right: image slider --}}
        <div class="lp-right">
            <div class="rp-circle rp-circle-1"></div>
            <div class="rp-circle rp-circle-2"></div>
            <div class="rp-tagline" id="rp-tagline">Discover beauty,<br>test before you glow</div>
            <div class="rp-slides">
                <div class="rp-track" id="rp-track">
                    <div class="rp-slide">
                        <img src="{{ asset('images/frontend/slider1.webp') }}" />
                        <div class="rp-overlay"></div>
                        <div class="rp-caption">Know what's really inside your cosmetics</div>
                    </div>
                    <div class="rp-slide">
                        <img src="{{ asset('images/frontend/slider2.webp') }}"
                            alt="Makeup products" />
                        <div class="rp-overlay"></div>
                        <div class="rp-caption">Review lipsticks, blush &amp; more</div>
                    </div>
                    <div class="rp-slide">
                        <img src="{{ asset('images/frontend/slider3.webp') }}"
                            alt="Beauty model" />
                        <div class="rp-overlay"></div>
                        <div class="rp-caption">Share your glow with the world</div>
                    </div>
                </div>
            </div>
            <div class="rp-dots">
                <div class="rp-dot active" onclick="rpGoSlide(0)"></div>
                <div class="rp-dot" onclick="rpGoSlide(1)"></div>
                <div class="rp-dot" onclick="rpGoSlide(2)"></div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            let cur = 0;
            const taglines = [
                'Know what\'s really<br>inside your cosmetics',
                'The truth your<br>label won\'t tell you',
                'Independent labs,<br>honest verdicts'
            ];

            window.rpGoSlide = function(n) {
                cur = n;
                document.getElementById('rp-track').style.transform = 'translateX(-' + (n * 33.333) + '%)';
                const tEl = document.getElementById('rp-tagline');
                tEl.style.opacity = '0';
                setTimeout(function() {
                    tEl.innerHTML = taglines[n];
                    tEl.style.opacity = '1';
                }, 220);
                document.querySelectorAll('.rp-dot').forEach(function(d, i) {
                    d.classList.toggle('active', i === n);
                });
            };

            setInterval(function() {
                rpGoSlide((cur + 1) % 3);
            }, 3500);

            window.lpTogglePass = function() {
                var inp = document.getElementById('lp-pass');
                var icon = document.getElementById('lp-eye-icon');
                inp.type = inp.type === 'password' ? 'text' : 'password';
                icon.className = inp.type === 'password' ? 'ti ti-eye' : 'ti ti-eye-off';
            };
        })();
    </script>
@endpush
