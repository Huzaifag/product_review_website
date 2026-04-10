<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshTrendingBusinesses extends Command
{
    protected $signature = 'app:refresh-trending-businesses';

    protected $description = 'This command is to refresh trending businesses';

    public function handle()
    {
        $trendingBusinesses = Business::active()->trending()->get();
        foreach ($trendingBusinesses as $trendingBusiness) {
            $trendingBusiness->is_trending = Business::NOT_TRENDING;
            $trendingBusiness->save();
        }

        $businesses = Business::active()
            ->where('current_month_views', '>', 0)
            ->orderBy('current_month_views', 'desc')
            ->take(config('settings.business.trending_number'))
            ->get();

        if ($businesses->count() < config('settings.business.trending_number')) {
            $businesses = Business::active()
                ->where('total_views', '>', 0)
                ->orderBy('total_views', 'desc')
                ->take(config('settings.business.trending_number'))
                ->get();
        }

        foreach ($businesses as $business) {
            $business->is_trending = Business::TRENDING;
            $business->save();
        }

        Artisan::call('optimize:clear');

        $this->info('Trending businesses has been refreshed successfully');
    }
}
