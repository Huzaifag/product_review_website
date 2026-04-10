<?php

namespace App\Classes;

use Illuminate\Support\Str;
use Spatie\SchemaOrg\Schema;

class SchemaGenerator
{
    public function render($__env, $method = null, $options = [])
    {
        $method = $method ? 'handle' . Str::studly($method) . 'Schema' : 'handleDefaultSchema';
        $schemas = $this->{$method}($__env, $options);
        $jsonSchemas = '';
        foreach ($schemas as $schema) {
            $encodedSchema = json_encode($schema, JSON_UNESCAPED_SLASHES); // | JSON_PRETTY_PRINT
            $encodedSchema = str_replace(['%7B', '%7D'], ['{', '}'], $encodedSchema);

            $jsonSchemas .= '<script type="application/ld+json">' . $encodedSchema . '</script>';
        }
        return $jsonSchemas;
    }

    public function handleDefaultSchema($__env, $options = [])
    {
        $organizationSchema = Schema::organization()
            ->name(m_trans(config('settings.general.site_name')))
            ->url(url('/'))
            ->logo(asset(config('theme.settings.general.logo_dark')));

        if (config('settings.general.contact_email')) {
            $organizationSchema->contactPoint([
                Schema::contactPoint()
                    ->email(config('settings.general.contact_email'))
                    ->contactType('Contact'),
            ]);
        }

        $websiteSchema = Schema::webSite()
            ->url(url('/'))
            ->potentialAction(
                Schema::searchAction()
                    ->target(route('businesses.index', ['search' => '{search_term_string}']))
                    ->setProperty('query-input', 'required name=search_term_string')
            );

        $webPageSchema = Schema::webPage()
            ->name(seoTitle($__env));
        if ($__env->yieldContent('description')) {
            $webPageSchema->description($__env->yieldContent('description'));
        }
        $webPageSchema->publisher(
            Schema::organization()
                ->name(m_trans(config('settings.general.site_name')))
        );

        return [
            $organizationSchema->toArray(),
            $websiteSchema->toArray(),
            $webPageSchema->toArray(),
        ];
    }

    public function handleBusinessSchema($__env, $options = [])
    {
        $business = $options['business'];
        $firstCategories = $business->getFirstCategories();

        $businessSchema = Schema::localBusiness()
            ->name($business->trans->name)
            ->description(strip_tags($business->trans->description ?? ''))
            ->url($business->getLink())
            ->image($business->getLogoLink())
            ->address(
                Schema::postalAddress()
                    ->streetAddress($business->address ?? '')
                    ->addressLocality($business->city ?? '')
                    ->addressRegion($business->state ?? '')
                    ->postalCode($business->zip ?? '')
                    ->addressCountry($business->getCountry())
            )
            ->telephone($business->phone ?? '')
            ->email($business->email ?? '')
            ->mainEntityOfPage($business->getLink())
            ->aggregateRating(
                $business->total_reviews > 0
                ? Schema::aggregateRating()
                    ->ratingValue(number_format($business->avg_ratings, 1))
                    ->reviewCount($business->total_reviews)
                : null
            )
            ->additionalType($business->hasCategory() ? $business->category->trans->name ?? null : null)
            ->knowsAbout(
                collect([
                    $firstCategories?->subCategory?->trans->name,
                    ...(
                        $firstCategories?->subSubCategories
                        ? $firstCategories->subSubCategories
                            ->map(fn($subSub) => $subSub->trans->name ?? null)
                            ->filter()
                            ->values()
                            ->toArray()
                        : []
                    ),
                ])->filter()->unique()->values()->toArray()
            );

        return [
            $businessSchema->toArray(),
        ];
    }

    public function handleArticleSchema($__env, $options = [])
    {
        $article = $options['article'];

        $articleSchema = Schema::article()
            ->headline($article->title)
            ->author(Schema::organization()->name(m_trans(config('settings.general.site_name'))))
            ->datePublished($article->created_at->format('Y-m-d'))
            ->dateModified($article->updated_at->format('Y-m-d'))
            ->mainEntityOfPage($article->getLink())
            ->image($article->image ? $article->getImageLink() : asset(config('theme.settings.general.social_image')))
            ->publisher(
                Schema::organization()
                    ->name(m_trans(config('settings.general.site_name')))
                    ->logo(Schema::imageObject()->url(asset(config('theme.settings.general.logo_dark'))))
            )
            ->description($article->description);

        return [
            $articleSchema->toArray(),
        ];
    }

}
