{{-- sidebar.blade.php --}}
<aside class="dashboard-sidebar">
    <div class="overlay"></div>

    {{-- Logo --}}
    <div class="dashboard-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="dashboard-sidebar-logo">
            <img src="{{ asset(config('theme.settings.general.logo_light')) }}"
                alt="{{ m_trans(config('settings.general.site_name')) }}" />
        </a>
    </div>

    <div class="dashboard-sidebar-menu" data-simplebar>
        <div class="dashboard-sidebar-links">
            <div class="dashboard-sidebar-links-cont">

                {{-- OVERVIEW --}}
                <div class="sb-section-label">{{ d_trans('Overview') }}</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="dashboard-sidebar-link {{ currentLink('dashboard', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-gauge-high sb-icon sb-icon-blue"></i>{{ d_trans('Dashboard') }}</span>
                    </p>
                </a>

                {{-- CATALOG --}}
                <div class="sb-section-label">{{ d_trans('Catalog') }}</div>

                <a href="{{ route('admin.products.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('products', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-box-open sb-icon sb-icon-violet"></i>{{ d_trans('Products') }}</span>
                    </p>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('categories', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-layer-group sb-icon sb-icon-teal"></i>{{ d_trans('Categories') }}</span>
                    </p>
                </a>

                <a href="{{ route('admin.brands.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('brands', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-certificate sb-icon sb-icon-orange"></i>{{ d_trans('Brands') }}</span>
                    </p>
                </a>

                <a href="{{ route('admin.test-attributes.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('test-attributes', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-vial sb-icon sb-icon-cyan"></i>{{ d_trans('Test Attributes') }}</span>
                    </p>
                </a>

                <a href="{{ route('admin.ingredients-library.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('ingredients-library', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-flask sb-icon sb-icon-green"></i>{{ d_trans('Ingredient Library') }}</span>
                    </p>
                </a>

                {{-- COMMUNITY --}}
                <div class="sb-section-label">{{ d_trans('Community') }}</div>

                <a href="{{ route('admin.reviews.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('reviews', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fa-solid fa-star sb-icon sb-icon-rose"></i>{{ d_trans('Reviews') }}</span>
                    </p>
                </a>

                <div class="dashboard-sidebar-link {{ activeLink('members', 2) }}" data-toggle>
                    <p class="dashboard-sidebar-link-title toggle-title">
                        <span><i class="fa-solid fa-users sb-icon sb-icon-indigo"></i>{{ d_trans('Members') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.members.users.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('users', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Users') }}</span></p>
                        </a>
                        <a href="{{ route('admin.members.admins.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('admins', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Admins') }}</span></p>
                        </a>
                    </div>
                </div>

                @if (config('settings.kyc.actions.status'))
                    <a href="{{ route('admin.kyc-verifications.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('kyc-verifications', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span><i
                                    class="fa-solid fa-id-card sb-icon sb-icon-green"></i>{{ d_trans('KYC Verifications') }}</span>
                            @if ($sidebarCounters['kyc_verifications'])
                                <span class="counter">{{ numberFormat($sidebarCounters['kyc_verifications']) }}</span>
                            @endif
                        </p>
                    </a>
                @endif

                {{-- MARKETING --}}
                <div class="sb-section-label">{{ d_trans('Marketing') }}</div>

                <a href="{{ route('admin.advertisements.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('advertisements', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-rectangle-ad sb-icon sb-icon-amber"></i>{{ d_trans('Advertisements') }}</span>
                    </p>
                </a>

                @if (config('settings.actions.blog'))
                    <div class="dashboard-sidebar-link {{ activeLink('blog', 2) }}" data-toggle>
                        <p class="dashboard-sidebar-link-title toggle-title">
                            <span><i
                                    class="fa-solid fa-newspaper sb-icon sb-icon-orange"></i>{{ d_trans('Blog') }}</span>
                            @if (!empty($sidebarCounters['blog_comments']))
                                <span class="counter">{{ numberFormat($sidebarCounters['blog_comments']) }}</span>
                            @endif
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="dashboard-sidebar-link-menu">
                            <a href="{{ route('admin.blog.articles.index') }}"
                                class="dashboard-sidebar-link {{ currentLink('articles', 3) }}">
                                <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Articles') }}</span></p>
                            </a>
                            <a href="{{ route('admin.blog.categories.index') }}"
                                class="dashboard-sidebar-link {{ currentLink('categories', 3) }}">
                                <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Categories') }}</span></p>
                            </a>
                            <a href="{{ route('admin.blog.comments.index') }}"
                                class="dashboard-sidebar-link {{ currentLink('comments', 3) }}">
                                <p class="dashboard-sidebar-link-title">
                                    <span>{{ d_trans('Comments') }}</span>
                                    @if (!empty($sidebarCounters['blog_comments']))
                                        <span
                                            class="counter">{{ numberFormat($sidebarCounters['blog_comments']) }}</span>
                                    @endif
                                </p>
                            </a>
                        </div>
                    </div>
                @endif

                <div class="dashboard-sidebar-link {{ activeLink('newsletter', 2) }}" data-toggle>
                    <p class="dashboard-sidebar-link-title toggle-title">
                        <span><i
                                class="fa-solid fa-envelope-open-text sb-icon sb-icon-rose"></i>{{ d_trans('Newsletter') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.newsletter.settings') }}"
                            class="dashboard-sidebar-link {{ currentLink('settings', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Settings') }}</span></p>
                        </a>
                        <a href="{{ route('admin.newsletter.subscribers.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('subscribers', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Subscribers') }}</span></p>
                        </a>
                    </div>
                </div>

                {{-- MONETIZATION --}}
                <div class="sb-section-label">{{ d_trans('Monetization') }}</div>

                <a href="{{ route('admin.plans.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('plans', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fa-solid fa-gem sb-icon sb-icon-violet"></i>{{ d_trans('Plans') }}</span>
                    </p>
                </a>

                @if (licenseType(2) && config('settings.subscription.status'))
                    <a href="{{ route('admin.subscriptions.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('subscriptions', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span><i
                                    class="fa-solid fa-crown sb-icon sb-icon-amber"></i>{{ d_trans('Subscriptions') }}</span>
                        </p>
                    </a>
                @endif

                <a href="{{ route('admin.transactions.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('transactions', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-money-bill-transfer sb-icon sb-icon-green"></i>{{ d_trans('Transactions') }}</span>
                    </p>
                </a>

                {{-- SYSTEM --}}
                <div class="sb-section-label">{{ d_trans('System') }}</div>

                <div class="dashboard-sidebar-link {{ activeLink('sections', 2) }}" data-toggle>
                    <p class="dashboard-sidebar-link-title toggle-title">
                        <span><i
                                class="fa-solid fa-puzzle-piece sb-icon sb-icon-teal"></i>{{ d_trans('Sections') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.sections.home-sections.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('home-sections', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Home Sections') }}</span></p>
                        </a>
                        <a href="{{ route('admin.sections.faqs.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('faqs', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('FAQs') }}</span></p>
                        </a>
                    </div>
                </div>

                <div class="dashboard-sidebar-link {{ activeLink('navigation', 2) }}" data-toggle>
                    <p class="dashboard-sidebar-link-title toggle-title">
                        <span><i
                                class="fa-solid fa-compass sb-icon sb-icon-cyan"></i>{{ d_trans('Navigation') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.navigation.navbar-links.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('navbar-links', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Navbar Links') }}</span></p>
                        </a>
                        <a href="{{ route('admin.navigation.footer-links.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('footer-links', 3) }}">
                            <p class="dashboard-sidebar-link-title"><span>{{ d_trans('Footer Links') }}</span></p>
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.settings.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('settings', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i
                                class="fa-solid fa-sliders sb-icon sb-icon-indigo"></i>{{ d_trans('Settings') }}</span>
                    </p>
                </a>

                {{-- AI TOOLS --}}
                @if (isAddonActive('ai_reviewer') || isAddonActive('ai_review_writer'))
                    <div class="sb-section-label">{{ d_trans('AI Tools') }}</div>
                @endif

                @if (isAddonActive('ai_reviewer'))
                    <a href="{{ route('admin.ai-reviewer.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('ai-reviewer', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span class="me-auto"><i
                                    class="fas fa-robot sb-icon sb-icon-blue"></i>{{ d_trans('AI Reviewer') }}</span>
                            {!! addonBadge('ai_reviewer') !!}
                        </p>
                    </a>
                @endif

                @if (isAddonActive('ai_review_writer'))
                    <a href="{{ route('admin.ai-review-writer.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('ai-review-writer', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span class="me-auto"><i
                                    class="fas fa-pen-fancy sb-icon sb-icon-violet"></i>{{ d_trans('AI Review Writer') }}</span>
                            {!! addonBadge('ai_review_writer') !!}
                        </p>
                    </a>
                @endif

            </div>
        </div>
    </div>

    {{-- Admin profile footer --}}
    <div class="sb-profile">
        <div class="sb-profile-avatar">
            <img src="{{ authAdmin()->getAvatar() }}" alt="{{ authAdmin()->getName() }}">
        </div>
        <div class="sb-profile-info">
            <span class="sb-profile-name">{{ shorterText(authAdmin()->getName(), 18) }}</span>
            <span class="sb-profile-role">{{ d_trans('Administrator') }}</span>
        </div>
        <a href="{{ route('admin.account.settings.index') }}" class="sb-profile-action"
            title="{{ d_trans('Settings') }}">
            <i class="fa-solid fa-gear"></i>
        </a>
    </div>
</aside>




<style>
    /* =============================================================
   MODERN ADMIN SIDEBAR — Full Redesign
   Palette: deep dark navy + vibrant colored icons
   ============================================================= */

    /* ─── Sidebar shell ─────────────────────────────────────────── */
    .dashboard-sidebar {
        background: rgb(249, 250, 251);
        border-right: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
        width: var(--sidebar_width);
        display: flex;
        flex-direction: column;
    }

    /* ─── Header ─────────────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-header {
        background: transparent;
        height: 68px;
        padding: 0 22px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .dashboard-sidebar .dashboard-sidebar-header .dashboard-sidebar-logo img {
        height: 36px;
        max-width: 100%;
        object-fit: contain;
    }

    /* ─── Scrollable menu area ───────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu {
        background: transparent;
        flex: 1;
        min-height: 0;
        height: calc(100% - 68px - 72px);
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links {
        padding: 8px 0 20px;
    }

    /* ─── Section label ──────────────────────────────────────────── */
    .sb-section-label {
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(220, 38, 38, 0.45);
        padding: 20px 20px 6px;
        line-height: 1;
        user-select: none;
    }

    .sb-section-label:first-child {
        padding-top: 12px;
    }

    /* ─── Items container ────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont {
        padding: 0 10px;
    }

    /* ─── Every link/group block ─────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link {
        text-decoration: none;
        display: block;
        margin-bottom: 1px;
    }

    /* ─── Link title row ─────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title {
        display: flex;
        align-items: center;
        font-size: 0.8125rem;
        font-weight: 400;
        line-height: 1.4;
        padding: 0.55rem 0.9rem;
        color: #070707;
        cursor: pointer;
        border-radius: 10px;
        transition: background 0.18s ease, color 0.18s ease;
        margin-bottom: 0;
        gap: 0;
    }

    /* ─── Span base ──────────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title span {
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    /* ─── Colored icon boxes ─────────────────────────────────────── */
    .sb-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 7px;
        font-size: 0.7rem;
        margin-right: 11px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .sb-icon-blue {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
    }

    .sb-icon-violet {
        background: rgba(139, 92, 246, 0.15);
        color: #a78bfa;
    }

    .sb-icon-teal {
        background: rgba(20, 184, 166, 0.15);
        color: #2dd4bf;
    }

    .sb-icon-cyan {
        background: rgba(6, 182, 212, 0.15);
        color: #22d3ee;
    }

    .sb-icon-orange {
        background: rgba(249, 115, 22, 0.15);
        color: #fb923c;
    }

    .sb-icon-rose {
        background: rgba(244, 63, 94, 0.15);
        color: #fb7185;
    }

    .sb-icon-indigo {
        background: rgba(99, 102, 241, 0.15);
        color: #818cf8;
    }

    .sb-icon-green {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
    }

    .sb-icon-amber {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
    }

    /* ─── Hover ──────────────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title:hover {
        background: rgba(220, 38, 38, 0.06);
        color: #070707;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title:hover .sb-icon {
        transform: scale(1.1);
    }

    /* ─── Active / current state ─────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title {
        background: rgba(220, 38, 38, 0.1);
        color: #070707;
        font-weight: 600;
        font-size:14px;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon {
        background: rgba(220, 38, 38, 0.18);
        box-shadow: 0 0 0 1px rgba(220, 38, 38, 0.35);
    }

    /* Override default icon-box rule for specific color classes when active */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-blue {
        background: rgba(59, 130, 246, .28);
        box-shadow: 0 0 0 1px rgba(59, 130, 246, .5);
        color: #93c5fd;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-violet {
        background: rgba(139, 92, 246, .28);
        box-shadow: 0 0 0 1px rgba(139, 92, 246, .5);
        color: #817b97;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-teal {
        background: rgba(20, 184, 166, .28);
        box-shadow: 0 0 0 1px rgba(20, 184, 166, .5);
        color: #5eead4;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-cyan {
        background: rgba(6, 182, 212, .28);
        box-shadow: 0 0 0 1px rgba(6, 182, 212, .5);
        color: #67e8f9;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-orange {
        background: rgba(249, 115, 22, .28);
        box-shadow: 0 0 0 1px rgba(249, 115, 22, .5);
        color: #fdba74;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-rose {
        background: rgba(244, 63, 94, .28);
        box-shadow: 0 0 0 1px rgba(244, 63, 94, .5);
        color: #fda4af;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-indigo {
        background: rgba(99, 102, 241, .28);
        box-shadow: 0 0 0 1px rgba(99, 102, 241, .5);
        color: #a5b4fc;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-green {
        background: rgba(34, 197, 94, .28);
        box-shadow: 0 0 0 1px rgba(34, 197, 94, .5);
        color: #86efac;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.current>.dashboard-sidebar-link-title .sb-icon-amber {
        background: rgba(245, 158, 11, .28);
        box-shadow: 0 0 0 1px rgba(245, 158, 11, .5);
        color: #fcd34d;
    }

    /* ─── Arrow chevron ──────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title .arrow {
        margin-left: auto;
        font-size: 10px;
        color: rgba(185, 28, 28, 0.35);
        flex-shrink: 0;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title .arrow i {
        display: inline-flex;
        width: auto !important;
        height: auto !important;
        min-width: unset !important;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        margin-right: 0 !important;
        border-radius: 0 !important;
        color: inherit;
        font-size: 10px;
        transition: transform 0.25s ease;
    }

    /* ─── Counter badge ──────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title .counter {
        font-size: 9px;
        font-weight: 700;
        padding: 2px 7px;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        margin-left: auto;
        border-radius: 30px;
        color: #fff;
        letter-spacing: 0.3px;
        line-height: 1.5;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.45);
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-title .counter+.arrow {
        margin-left: 8px;
    }

    /* ─── Dropdown submenu ───────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-menu {
        height: 0;
        overflow: hidden;
        transition: height 0.28s ease;
        padding: 0 2px;
    }

    /* ─── Child link rows ────────────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-menu .dashboard-sidebar-link .dashboard-sidebar-link-title {
        padding: 0.44rem 0.9rem 0.44rem 44px;
        font-size: 0.775rem;
        color: rgba(185, 28, 28, 0.55);
        border-left: none;
        border-radius: 8px;
        margin-bottom: 0;
        position: relative;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-menu .dashboard-sidebar-link .dashboard-sidebar-link-title>span::before {
        content: '';
        display: inline-block;
        width: 5px;
        height: 5px;
        min-width: 5px;
        border-radius: 50%;
        background: rgba(185, 28, 28, 0.2);
        margin-right: 10px;
        flex-shrink: 0;
        transition: background 0.2s, box-shadow 0.2s;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-menu .dashboard-sidebar-link .dashboard-sidebar-link-title:hover {
        background: rgba(220, 38, 38, 0.06);
        color: #b91c1c;
        border-left-color: transparent;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-menu .dashboard-sidebar-link.current>.dashboard-sidebar-link-title {
        color: #dc2626;
        background: rgba(220, 38, 38, 0.08);
        font-weight: 600;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link .dashboard-sidebar-link-menu .dashboard-sidebar-link.current .dashboard-sidebar-link-title>span::before {
        background: #dc2626;
        box-shadow: 0 0 6px rgba(220, 38, 38, 0.6);
    }

    /* ─── Expanded group state ───────────────────────────────────── */
    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.active>.dashboard-sidebar-link-title {
        color: #b91c1c;
        background: rgba(220, 38, 38, 0.06);
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.active .dashboard-sidebar-link-menu {
        margin-bottom: 4px;
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.active .dashboard-sidebar-link-title .arrow {
        color: rgba(185, 28, 28, 0.5);
    }

    .dashboard-sidebar .dashboard-sidebar-menu .dashboard-sidebar-links .dashboard-sidebar-links-cont .dashboard-sidebar-link.active .dashboard-sidebar-link-title .arrow i {
        transform: rotate(90deg);
    }

    /* ─── Simplebar scrollbar ────────────────────────────────────── */
    .dashboard-sidebar .simplebar-scrollbar::before {
        background: rgba(220, 38, 38, 0.35);
        border-radius: 4px;
    }

    .dashboard-sidebar .simplebar-track.simplebar-vertical {
        width: 4px;
    }

    /* ─── Mobile overlay ─────────────────────────────────────────── */
    .dashboard-sidebar .overlay {
        background-color: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(3px);
    }

    /* ─── Admin profile footer ───────────────────────────────────── */
    .sb-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        background: rgba(0, 0, 0, 0.02);
        flex-shrink: 0;
    }

    .sb-profile-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid rgba(220, 38, 38, 0.3);
    }

    .sb-profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sb-profile-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .sb-profile-name {
        font-size: 13px;
        font-weight: 600;
        color: rgba(185, 28, 28, 0.9);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }

    .sb-profile-role {
        font-size: 11px;
        color: rgba(185, 28, 28, 0.45);
        line-height: 1.3;
    }

    .sb-profile-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(185, 28, 28, 0.45);
        font-size: 14px;
        text-decoration: none;
        transition: background 0.18s, color 0.18s;
        flex-shrink: 0;
    }

    .sb-profile-action:hover {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
    }
</style>
