<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshBestRatingBusinesses extends Command
{
    protected $signature = 'app:refresh-best-rating-businesses';

    protected $description = 'This command is to refresh best rating businesses';

    public function handle()
    {
        $bestRatingBusinesses = Business::active()->bestRating()->get();
        foreach ($bestRatingBusinesses as $bestRatingBusiness) {
            $bestRatingBusiness->is_best_rating = Business::NOT_BEST_RATING;
            $bestRatingBusiness->save();
        }

        $businesses = Business::active()
            ->where('avg_ratings', '>', 0)
            ->orderBy('avg_ratings', 'desc')
            ->take(config('settings.business.best_rating_number'))
            ->get();

        foreach ($businesses as $business) {
            $business->is_best_rating = Business::BEST_RATING;
            $business->save();
        }

        Artisan::call('optimize:clear');

        $this->info('Best rating businesses has been refreshed successfully');
    }
}
