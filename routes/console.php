<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

if (config('settings.business.actions.reviews_require_reviewing')
    && isAddonActive('ai_reviewer') && config('settings.ai_reviewer.status')) {
    Schedule::command('app:ai-reviewer')->everyMinute();
}

Schedule::command('app:reset-item-month-views')->monthlyOn(1, '00:00');

Schedule::command('app:refresh-trending-businesses')->daily();
Schedule::command('app:refresh-best-rating-businesses')->daily();

Schedule::command('app:delete-unpaid-transactions')->daily();

Schedule::command('app:delete-temp-files')->hourly();
Schedule::command('app:sitemap-generate')->daily();
Schedule::command('disposable:update')->weekly();

if (licenseType(2) && config('settings.subscription.status')) {
    Schedule::command('app:subscription-about-to-expire-notification')->everyMinute();
    Schedule::command('app:subscription-expired-notification')->everyMinute();
}