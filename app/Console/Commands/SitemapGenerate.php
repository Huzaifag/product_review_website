<?php

namespace App\Console\Commands;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\Business;
use App\Models\Category;
use App\Models\FooterLink;
use App\Models\NavbarLink;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerate extends Command
{
    protected $signature = 'app:sitemap-generate';

    protected $description = 'Generate website sitemap.xml';

    public function handle()
    {
        $limit = 40000;
        $sitemapIndex = SitemapIndex::create();
        $chunk = 1;

        $sitemap = Sitemap::create();

        $writeSitemapFile = function ($sitemap, $chunk, $sitemapIndex) {
            $filename = "sitemap_{$chunk}.xml";
            $sitemap->writeToFile(public_path($filename));
            $sitemapIndex->add("/$filename");
        };

        $navbarLinks = NavbarLink::all();
        foreach ($navbarLinks as $navbarLink) {
            $sitemap->add(
                Url::create($navbarLink->link)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
        }

        foreach ($this->fixedLinks() as $link) {
            $sitemap->add(
                Url::create($link)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
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

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
        }

        $subCategories = SubCategory::all();
        foreach ($subCategories as $subCategory) {
            $sitemap->add(
                Url::create($subCategory->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
        }

        $subSubCategories = SubSubCategory::all();
        foreach ($subSubCategories as $subSubCategory) {
            $sitemap->add(
                Url::create($subSubCategory->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
        }

        $businesses = Business::active()->get();
        foreach ($businesses as $business) {
            $sitemap->add(
                Url::create($business->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
                    ->addImage($business->getLogoLink())
            );

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
        }

        $blogCategories = BlogCategory::all();
        foreach ($blogCategories as $blogCategory) {
            $sitemap->add(
                Url::create($blogCategory->getLink())
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
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

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
        }

        $footerLinks = FooterLink::all();
        foreach ($footerLinks as $footerLink) {
            $sitemap->add(
                Url::create($footerLink->link)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
            );

            if (count($sitemap->getTags()) >= $limit) {
                $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                $chunk++;
                $sitemap = Sitemap::create();
            }
        }

        if (count($sitemap->getTags()) > 0) {
            $writeSitemapFile($sitemap, $chunk, $sitemapIndex);
        }

        $sitemapIndex->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully');
    }

    private function fixedLinks()
    {
        return [
            route('login'),
            route('register'),
            route('business.login'),
            route('business.register'),
        ];
    }
}