<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(d_trans('Home'), route('home'));
});

Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(d_trans('Categories'), route('categories.index'));
});

Breadcrumbs::for('categories.category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('categories');
    $trail->push($category->trans->name, $category->getLink());
});

Breadcrumbs::for('categories.sub-category', function (BreadcrumbTrail $trail, $subCategory) {
    $trail->parent('categories.category', $subCategory->category);
    $trail->push($subCategory->trans->name, $subCategory->getLink());
});

Breadcrumbs::for('categories.sub-sub-category', function (BreadcrumbTrail $trail, $subSubCategory) {
    $trail->parent('categories.sub-category', $subSubCategory->subCategory);
    $trail->push($subSubCategory->trans->name, $subSubCategory->getLink());
});


Breadcrumbs::for('products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(d_trans('Products'), route('products.index'));
});

Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('products.index');
});

Breadcrumbs::for('products.show', function (BreadcrumbTrail $trail, $product) {
    if ($product->category) {
        $trail->parent('categories.category', $product->category);
    } else {
        $trail->parent('home');
    }

    if ($product->subCategory) {
        $trail->push($product->subCategory->trans->name, $product->subCategory->getLink());
    }

    $trail->push($product->name, $product->getLink());
});

Breadcrumbs::for('businesses', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(d_trans('Businesses'), route('businesses.index'));
});

Breadcrumbs::for('businesses.show', function (BreadcrumbTrail $trail, $business) {
    $trail->parent('businesses');
    $trail->push($business->category->trans->name, $business->category->getLink());
    $categories = $business->getFirstCategories();
    if ($categories) {
        $subCategory = $categories->subCategory;
        $subSubCategory = $categories->subSubCategories->first();
        $trail->push($subCategory->trans->name, $subCategory->getLink());
        $trail->push($subSubCategory->trans->name, $subSubCategory->getLink());
    }
});

Breadcrumbs::for('businesses.review', function (BreadcrumbTrail $trail, $business) {
    $trail->parent('businesses');
    $trail->push($business->trans->name, $business->getLink());
    $trail->push(d_trans('Review'), $business->getWriteReviewLink());
});

Breadcrumbs::for('businesses.review.show', function (BreadcrumbTrail $trail, $review) {
    $trail->parent('businesses.review', $review->business);
    $trail->push($review->id, $review->getLink());
});

Breadcrumbs::for('faqs', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(d_trans('FAQs'), route('faqs'));
});

Breadcrumbs::for('contact', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(d_trans('Contact US'), route('contact'));
});

Breadcrumbs::for('page', function (BreadcrumbTrail $trail, $page) {
    $trail->parent('home');
    $trail->push($page->title, $page->getLink());
});

Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(d_trans('Blog'), route('blog.index'));
});

Breadcrumbs::for('blog_category', function (BreadcrumbTrail $trail, $blogCategory) {
    $trail->parent('blog');
    $trail->push($blogCategory->name, route('blog.category', $blogCategory->slug));
});

Breadcrumbs::for('blog_article', function (BreadcrumbTrail $trail, $blogArticle) {
    $trail->parent('blog_category', $blogArticle->category);
    $trail->push($blogArticle->title, $blogArticle->getLInk());
});

Breadcrumbs::for('user.profile', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('home');
    $trail->push(d_trans('Profile'), $user->getProfileLink());
});

Breadcrumbs::for('user.settings', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.profile', $user);
    $trail->push(d_trans('Settings'), $user->getSettingsLink());
});

Breadcrumbs::for('user.kyc', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.profile', $user);
    $trail->push(d_trans('KYC Verification'), $user->getKycLink());
});

Breadcrumbs::for('business', function (BreadcrumbTrail $trail) {
    $trail->push(d_trans('Business'), route('business.index'));
});

Breadcrumbs::for('business.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Dashboard'), route('business.dashboard'));
});

Breadcrumbs::for('business.reviews', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Reviews'), route('business.reviews.index'));
});

Breadcrumbs::for('business.employees', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Employees'), route('business.employees.index'));
});

Breadcrumbs::for('business.categories', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Categories'), route('business.categories.index'));
});

Breadcrumbs::for('business.integration', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Integration'), route('business.integration'));
});

Breadcrumbs::for('business.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Settings'), route('business.settings.index'));
});

Breadcrumbs::for('business.notifications', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Notifications'), route('business.notifications.index'));
});

Breadcrumbs::for('business.subscription', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Subscription'), route('business.subscription.index'));
});

Breadcrumbs::for('business.subscription.transaction', function (BreadcrumbTrail $trail, $trx) {
    $trail->parent('business.subscription');
    $trail->push(d_trans('Transaction'), route('business.subscription.index'));
    $trail->push($trx->id, route('business.subscription.transactions.show', $trx->id));
});

Breadcrumbs::for('business.checkout', function (BreadcrumbTrail $trail, $transaction) {
    $trail->parent('business');
    $trail->push(d_trans('Checkout'), route('business.checkout.index', hash_encode($transaction->id)));
});

Breadcrumbs::for('business.account.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('business');
    $trail->push(d_trans('Account Settings'), route('business.account.settings.index'));
});
