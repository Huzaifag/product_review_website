<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class ResetBusinessMonthViews extends Command
{
    protected $signature = 'app:reset-business-month-views';

    protected $description = 'This command is to reset business monthly views';

    public function handle()
    {
        $businesses = Business::active()
            ->where('current_month_views', '>', 0)->get();

        foreach ($businesses as $business) {
            $business->current_month_views = 0;
            $business->update();
        }

        $this->info('Monthly views have been reset for all businesses.');
    }
}