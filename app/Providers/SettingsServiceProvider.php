<?php

namespace App\Providers;

use App\Classes\ThemeManager;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot(Request $request)
    {
        try {
            $settings = Setting::all()->pluck('value', 'key');
            $settingsPrefix = 'settings.';

            foreach ($settings as $key => $value) {
                if (is_object($value)) {
                    $this->setNestedConfig($settingsPrefix, $key, $value);
                } else {
                    config([$settingsPrefix . removeSpaces($key) => $value]);
                }
            }

            $themeSettings = app(ThemeManager::class)->getThemeSettings();
            $themeSettingsPrefix = 'theme.settings.';

            foreach ($themeSettings as $key => $value) {
                if (is_object($value)) {
                    $this->setNestedConfig($themeSettingsPrefix, $key, $value);
                } else {
                    config([$themeSettingsPrefix . removeSpaces($key) => $value]);
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    private function setNestedConfig($prefix, $parentKey, $object)
    {
        foreach ($object as $key => $value) {
            $fullKey = $parentKey . '.' . $key;

            if (is_object($value)) {
                $this->setNestedConfig($prefix, $fullKey, $value);
            } else {
                config([$prefix . removeSpaces($fullKey) => $value]);
            }
        }
    }
}