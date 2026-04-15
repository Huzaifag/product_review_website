<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\BlogArticle;
use App\Models\BlogComment;
use App\Models\Business;
use App\Models\BusinessNotification;
use App\Models\BusinessReview;
use App\Models\BusinessReviewReport;
use App\Models\Category;
use App\Models\Faq;
use App\Models\FooterLink;
use App\Models\KycVerification;
use App\Models\Product;
use App\Models\NavbarLink;
use App\Rules\BlockPatterns;
use App\Rules\Username;
use Carbon\Carbon;
use Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerBladeDirectives();
    }

    public function boot()
    {
        // Prevent "Specified key was too long" errors on older MySQL/MariaDB setups.
        Schema::defaultStringLength(191);

        Carbon::setLocale(getLocale());
        Paginator::useBootstrapFive();

        $this->modalBinding();
        $this->listenEvents();
        $this->validationExtends();

        if (config('system.install.complete')) {

            if (config('settings.actions.force_ssl')) {
                $this->app['request']->server->set('HTTPS', true);
            }

            $this->themeViewComposers();
            $this->adminViewComposers();
        }

        if (config('app.env') === 'production' || request()->isSecure()) {
            \URL::forceScheme('https');
        }



        \URL::forceScheme('https');

    }

    public function themeViewComposers()
    {
        theme_compose('includes.navbar', function ($view) {
            $cacheKey = languageCacheKey('navbar_links');
            $navbarLinks = Cache::rememberForever($cacheKey, function () {
                return NavbarLink::whereNull('parent_id')
                    ->with('children')
                    ->get();
            });
            $view->with('navbarLinks', $navbarLinks);
        });

        theme_compose('sections.categories', function ($view) {
            $categoriesSection = homeSection('categories');
            if ($categoriesSection) {
                $cacheMinutes = Carbon::now()->addMinutes($categoriesSection->cache_expiry_time);
                $cacheKey = languageCacheKey('home_categories_cache');
                $categories = Cache::remember($cacheKey, $cacheMinutes, function () use ($categoriesSection) {
                    return Category::inRandomOrder()
                        ->limit($categoriesSection->items_number ?? 10)
                        ->get();
                });
                $view->with('categories', $categories);
            }
        });

        theme_compose('sections.trending', function ($view) {
            $trendingSection = homeSection('trending');
            $cacheMinutes = Carbon::now()->addMinutes($trendingSection->cache_expiry_time);
            $trendingBusinesses = Cache::remember('home_trending_businesses_cache', $cacheMinutes, function () use ($trendingSection) {
                return Business::active()
                    ->trending()
                    ->inRandomOrder()
                    ->limit($trendingSection->items_number)
                    ->get();
            });
            $view->with([
                'trendingSection' => $trendingSection,
                'trendingBusinesses' => $trendingBusinesses,
            ]);
        });

        theme_compose('sections.best-rating', function ($view) {
            $bestRatingSection = homeSection('best_rating');
            $cacheMinutes = Carbon::now()->addMinutes($bestRatingSection->cache_expiry_time);
            $bestRatingBusinesses = Cache::remember('home_best_rating_businesses_cache', $cacheMinutes, function () use ($bestRatingSection) {
                return Business::active()
                    ->bestRating()
                    ->orderbyDesc('avg_ratings')
                    ->limit($bestRatingSection->items_number)
                    ->get();
            });
            $view->with([
                'bestRatingSection' => $bestRatingSection,
                'bestRatingBusinesses' => $bestRatingBusinesses,
            ]);
        });

        theme_compose('sections.featured', function ($view) {
            $featuredSection = homeSection('featured');
            $cacheMinutes = Carbon::now()->addMinutes($featuredSection->cache_expiry_time);
            $featuredProducts = Cache::remember('home_featured_products_cache', $cacheMinutes, function () use ($featuredSection) {
                return Product::where('is_active', true)
                    ->where('is_featured', true)
                    ->with(['category', 'subCategory'])
                    ->inRandomOrder()
                    ->limit($featuredSection->items_number)
                    ->get();
            });
            $view->with([
                'featuredSection' => $featuredSection,
                'featuredProducts' => $featuredProducts,
            ]);
        });

        theme_compose('sections.recent-reviews', function ($view) {
            $recentReviewsSection = homeSection('recent_reviews');
            $cacheMinutes = Carbon::now()->addMinutes($recentReviewsSection->cache_expiry_time);
            $recentReviews = Cache::remember('home_recent_reviews_cache', $cacheMinutes, function () use ($recentReviewsSection) {
                return BusinessReview::published()
                    ->orderbyDesc('id')
                    ->with(['user', 'business'])
                    ->limit($recentReviewsSection->items_number)
                    ->get()->shuffle();
            });
            $view->with([
                'recentReviewsSection' => $recentReviewsSection,
                'recentReviews' => $recentReviews,
            ]);
        });

        theme_compose('sections.faqs', function ($view) {
            $faqsSection = homeSection('faqs');
            if ($faqsSection) {
                $cacheMinutes = Carbon::now()->addMinutes($faqsSection->cache_expiry_time);
                $cacheKey = languageCacheKey('home_faqs_cache');
                $faqs = Cache::remember($cacheKey, $cacheMinutes, function () use ($faqsSection) {
                    return Faq::limit($faqsSection->items_number ?? 8)->get();
                });
                $view->with('faqs', $faqs);
            }
        });

        theme_compose('sections.blog-articles', function ($view) {
            if (config('settings.actions.blog')) {
                $blogArticlesSection = homeSection('blog_articles');
                if ($blogArticlesSection) {
                    $cacheMinutes = Carbon::now()->addMinutes($blogArticlesSection->cache_expiry_time);
                    $cacheKey = languageCacheKey('home_blog_articles_cache');
                    $blogArticles = Cache::remember($cacheKey, $cacheMinutes, function () use ($blogArticlesSection) {
                        return BlogArticle::limit($blogArticlesSection->items_number ?? 3)
                            ->with('category')->orderbyDesc('id')->get();
                    });
                    $view->with('blogArticles', $blogArticles);
                }
            }
        });

        theme_compose('includes.footer', function ($view) {
            $cacheKey = languageCacheKey('footer_links');
            $footerLinks = Cache::rememberForever($cacheKey, function () {
                return FooterLink::whereNull('parent_id')
                    ->with('children')
                    ->get();
            });
            $newsletterFooterStatus = config('settings.newsletter.status')
                && config('settings.newsletter.footer_status') && !request()->hasCookie('newsletter_subscribed');
            $view->with([
                'footerLinks' => $footerLinks,
                'newsletterFooterStatus' => $newsletterFooterStatus,
            ]);
        });

        theme_compose('business.*', function ($view) {
            $view->with('currentBusiness', currentBusiness());
        });

        theme_compose('business.includes.navbar', function ($view) {
            $navbarNotifications['list'] = BusinessNotification::where('business_id', currentBusiness()->id)
                ->orderbyDesc('id')->limit(20)->get();
            $navbarNotifications['unread'] = BusinessNotification::where('business_id', currentBusiness()->id)
                ->unread()->get()->count();
            $view->with('navbarNotifications', $navbarNotifications);
        });

        theme_compose('business.includes.sidebar', function ($view) {
            $sidebarBusinesses = collect();
            if (authBusinessOwner()) {
                $sidebarBusinesses = authBusinessOwner()->businesses()->active()->get();
            }
            $view->with('sidebarBusinesses', $sidebarBusinesses);
        });

        theme_compose('business.partials.add-business-modal', function ($view) {
            $modalCategories = Category::select('id', 'name')->get();
            $view->with('modalCategories', $modalCategories);
        });

    }

    public function adminViewComposers()
    {
        View::composer('admin.includes.navbar', function ($view) {
            $navbarNotifications['list'] = AdminNotification::orderbyDesc('id')->limit(20)->get();
            $navbarNotifications['unread'] = AdminNotification::unread()->get()->count();
            $view->with('navbarNotifications', $navbarNotifications);
        });

        View::composer('admin.includes.sidebar', function ($view) {
            $sidebarCounters['pending_reviews'] = BusinessReview::pending()->count();
            $sidebarCounters['reported_reviews'] = BusinessReviewReport::count();
            $sidebarCounters['kyc_verifications'] = KycVerification::pending()->count();
            $sidebarCounters['blog_comments'] = BlogComment::pending()->count();
            $view->with('sidebarCounters', $sidebarCounters);
        });
    }

    public function registerBladeDirectives()
    {
        Blade::directive('themeColors', function () {
            return '<link rel="stylesheet" href="' . theme_asset(config('theme.style.colors')) . '">';
        });

        Blade::directive('themeCustomStyle', function () {
            return '<link rel="stylesheet" href="' . theme_asset(config('theme.style.custom_css')) . '">';
        });

        Blade::directive('adminColors', function () {
            return '<link rel="stylesheet" href="' . asset(config('system.admin.colors')) . '">';
        });

        Blade::directive('adminCustomStyle', function () {
            return '<link rel="stylesheet" href="' . asset(config('system.admin.custom_css')) . '">';
        });
    }

    public function validationExtends()
    {
        Validator::extend('username', function ($attribute, $value, $parameters, $validator) {
            $rule = new Username;
            return $rule->passes($attribute, $value);
        });

        Validator::extend('block_patterns', function ($attribute, $value, $parameters, $validator) {
            $rule = new BlockPatterns;
            return $rule->passes($attribute, $value);
        });
    }

    public function listenEvents()
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('microsoft', \SocialiteProviders\Microsoft\Provider::class);
            $event->extendSocialite('vkontakte', \SocialiteProviders\VKontakte\Provider::class);
        });
    }

    public function modalBinding()
    {
        Route::bind('admin', function ($value) {
            return Admin::where('id', $value)
                ->whereNot('id', authAdmin()->id)
                ->firstOrFail();
        });
    }
}
