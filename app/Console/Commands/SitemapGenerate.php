<?php

namespace App\Console\Commands;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\Product;
use App\Models\Category;
use App\Models\FooterLink;
use App\Models\NavbarLink;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerate extends Command
{
    protected $signature = 'app:sitemap-generate';

    protected $description = 'Generate website sitemap.xml';

    public function handle()
    {
        $sitemap = Sitemap::create();

        $navbarLinks = NavbarLink::all();
        foreach ($navbarLinks as $navbarLink) {
            $sitemap->add(
                Url::create($navbarLink->link)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );
        }

        foreach ($this->fixedLinks() as $link) {
            $sitemap->add(
                Url::create($link)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );
        }

        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap->add(
                Url::create($category->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
                    ->addImage($category->getImageLink())
            );
        }

        $subCategories = SubCategory::has('category')->get();
        foreach ($subCategories as $subCategory) {
            $sitemap->add(
                Url::create($subCategory->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );
        }

        $subSubCategories = SubSubCategory::has('subCategory.category')->get();
        foreach ($subSubCategories as $subSubCategory) {
            $sitemap->add(
                Url::create($subSubCategory->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );
        }

        $products = Product::active()->get();
        foreach ($products as $product) {
            $sitemap->add(
                Url::create($product->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
                    ->addImage($product->getImageLink())
            );
        }

        $blogCategories = BlogCategory::all();
        foreach ($blogCategories as $blogCategory) {
            $sitemap->add(
                Url::create($blogCategory->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );
        }

        $blogArticles = BlogArticle::all();
        foreach ($blogArticles as $blogArticle) {
            $sitemap->add(
                Url::create($blogArticle->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
                    ->addImage($blogArticle->getImageLink())
            );
        }

        $footerLinks = FooterLink::all();
        foreach ($footerLinks as $footerLink) {
            $sitemap->add(
                Url::create($footerLink->link)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully');
    }

    private function fixedLinks()
    {
        return [];
    }
}