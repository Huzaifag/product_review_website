<aside class="dashboard-sidebar">
    <div class="overlay"></div>
    <div class="dashboard-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="dashboard-sidebar-logo">
            <img src="{{ asset(config('theme.settings.general.logo_light')) }}"
                alt="{{ m_trans(config('settings.general.site_name')) }}" />
        </a>
    </div>
    <div class="dashboard-sidebar-menu" data-simplebar>
        <div class="dashboard-sidebar-links">
            <div class="dashboard-sidebar-links-cont">
                <a href="{{ route('admin.dashboard') }}"
                    class="dashboard-sidebar-link {{ currentLink('dashboard', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fa-solid fa-table-columns"></i>{{ d_trans('Dashboard') }}</span>
                    </p>
                </a>
                <div class="dashboard-sidebar-link {{ activeLink('members', 2) }}" data-toggle>
                    <p class="dashboard-sidebar-link-title toggle-title">
                        <span><i class="fa-solid fa-user-group"></i>{{ d_trans('Members') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.members.users.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('users', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Users') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.members.admins.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('admins', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Admins') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.members.business-owners.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('business-owners', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Business Owners') }}</span>
                            </p>
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.businesses.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('businesses', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fa-solid fa-briefcase"></i>{{ d_trans('Businesses') }}</span>
                    </p>
                </a>
                <a href="{{ route('admin.pending-reviews.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('pending-reviews', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fas fa-history"></i>{{ d_trans('Pending Reviews') }}</span>
                        @if ($sidebarCounters['pending_reviews'])
                            <span class="counter">{{ numberFormat($sidebarCounters['pending_reviews']) }}</span>
                        @endif
                    </p>
                </a>
                <a href="{{ route('admin.reported-reviews.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('reported-reviews', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fas fa-flag"></i>{{ d_trans('Reported Reviews') }}</span>
                        @if ($sidebarCounters['reported_reviews'])
                            <span class="counter">{{ numberFormat($sidebarCounters['reported_reviews']) }}</span>
                        @endif
                    </p>
                </a>
                @if (isAddonActive('ai_reviewer'))
                    <a href="{{ route('admin.ai-reviewer.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('ai-reviewer', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span class="me-auto"><i class="fas fa-user-secret"></i>{{ d_trans('AI Reviewer') }}</span>
                            {!! addonBadge('ai_reviewer') !!}
                        </p>
                    </a>
                @endif
                @if (isAddonActive('ai_review_writer'))
                    <a href="{{ route('admin.ai-review-writer.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('ai-review-writer', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span class="me-auto"><i
                                    class="fas fa-pencil-alt"></i>{{ d_trans('AI Review Writer') }}</span>
                            {!! addonBadge('ai_review_writer') !!}
                        </p>
                    </a>
                @endif
                <a href="{{ route('admin.kyc-verifications.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('kyc-verifications', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="far fa-id-card"></i>{{ d_trans('KYC Verifications') }}</span>
                        @if ($sidebarCounters['kyc_verifications'])
                            <span class="counter">{{ numberFormat($sidebarCounters['kyc_verifications']) }}</span>
                        @endif
                    </p>
                </a>
                <a href="{{ route('admin.advertisements.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('advertisements', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fas fa-ad"></i>{{ d_trans('Advertisements') }}</span>
                    </p>
                </a>
                @if (licenseType(2) && config('settings.subscription.status'))
                    <a href="{{ route('admin.plans.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('plans', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span><i class="fas fa-money-check-alt"></i>{{ d_trans('Pricing Plans') }}</span>
                        </p>
                    </a>
                    <a href="{{ route('admin.subscriptions.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('subscriptions', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span><i class="far fa-gem"></i>{{ d_trans('Subscriptions') }}</span>
                        </p>
                    </a>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="dashboard-sidebar-link {{ currentLink('transactions', 2) }}">
                        <p class="dashboard-sidebar-link-title">
                            <span><i class="fas fa-receipt"></i>{{ d_trans('Transactions') }}</span>
                        </p>
                    </a>
                @endif
                <a href="{{ route('admin.categories.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('categories', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fa-solid fa-tags"></i>{{ d_trans('Categories') }}</span>
                    </p>
                </a>
                <div class="dashboard-sidebar-link {{ activeLink('navigation', 2) }}" data-toggle>
                    <p class="dashboard-sidebar-link-title toggle-title">
                        <span><i class="fa-solid fa-list-ul"></i>{{ d_trans('Navigation') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.navigation.navbar-links.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('navbar-links', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Navbar Links') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.navigation.footer-links.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('footer-links', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Footer Links') }}</span>
                            </p>
                        </a>
                    </div>
                </div>
                @if (config('settings.actions.blog'))
                    <div class="dashboard-sidebar-link {{ activeLink('blog', 2) }}" data-toggle>
                        <p class="dashboard-sidebar-link-title toggle-title">
                            <span><i class="fa-solid fa-rss"></i>{{ d_trans('Blog') }}</span>
                            @if ($sidebarCounters['blog_comments'])
                                <span class="counter">{{ numberFormat($sidebarCounters['blog_comments']) }}</span>
                            @endif
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="dashboard-sidebar-link-menu">
                            <a href="{{ route('admin.blog.articles.index') }}"
                                class="dashboard-sidebar-link {{ currentLink('articles', 3) }}">
                                <p class="dashboard-sidebar-link-title">
                                    <span>{{ d_trans('Articles') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.blog.categories.index') }}"
                                class="dashboard-sidebar-link {{ currentLink('categories', 3) }}">
                                <p class="dashboard-sidebar-link-title">
                                    <span>{{ d_trans('Categories') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.blog.comments.index') }}"
                                class="dashboard-sidebar-link {{ currentLink('comments', 3) }}">
                                <p class="dashboard-sidebar-link-title">
                                    <span>{{ d_trans('Comments') }}</span>
                                    @if ($sidebarCounters['blog_comments'])
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
                        <span><i class="fa-solid fa-envelope-open-text"></i>{{ d_trans('Newsletter') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.newsletter.settings') }}"
                            class="dashboard-sidebar-link {{ currentLink('settings', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Settings') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.newsletter.subscribers.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('subscribers', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Subscribers') }}</span>
                            </p>
                        </a>
                    </div>
                </div>
                <div class="dashboard-sidebar-link {{ activeLink('sections', 2) }}" data-toggle>
                    <p class="dashboard-sidebar-link-title toggle-title">
                        <span><i class="fa-solid fa-layer-group"></i>{{ d_trans('Sections') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="dashboard-sidebar-link-menu">
                        <a href="{{ route('admin.sections.home-sections.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('home-sections', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('Home Sections') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.sections.faqs.index') }}"
                            class="dashboard-sidebar-link {{ currentLink('faqs', 3) }}">
                            <p class="dashboard-sidebar-link-title">
                                <span>{{ d_trans('FAQs') }}</span>
                            </p>
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.settings.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('settings', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fa-solid fa-gear"></i>{{ d_trans('Settings') }}</span>
                    </p>
                </a>
                <a href="{{ route('admin.system.index') }}"
                    class="dashboard-sidebar-link {{ currentLink('system', 2) }}">
                    <p class="dashboard-sidebar-link-title">
                        <span><i class="fa-solid fa-server"></i>{{ d_trans('System') }}</span>
                    </p>
                </a>
            </div>
        </div>
    </div>
</aside>
