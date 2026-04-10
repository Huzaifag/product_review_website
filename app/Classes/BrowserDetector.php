<?php

namespace App\Classes;

class BrowserDetector
{
    public const BROWSERS = [
        '/msie/i' => 'Internet Explorer',
        '/trident/i' => 'Internet Explorer',
        '/edge/i' => 'Edge',
        '/chrome/i' => 'Chrome',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/opera/i' => 'Opera',
        '/opr/i' => 'Opera',
        '/brave/i' => 'Brave',
        '/vivaldi/i' => 'Vivaldi',
        '/yabrowser/i' => 'Yandex Browser',
        '/ucbrowser/i' => 'UC Browser',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser',
        '/android/i' => 'Android Browser',
        '/iphone/i' => 'iPhone Browser',
        '/silk/i' => 'Amazon Silk',
        '/googlebot/i' => 'Googlebot',
        '/bingbot/i' => 'Bingbot',
        '/slurp/i' => 'Yahoo! Slurp',
        '/duckduckbot/i' => 'DuckDuckGo Bot',
        '/baiduspider/i' => 'Baidu Spider',
        '/yandexbot/i' => 'Yandex Bot',
    ];

    public static function get($agent = null)
    {
        $agent = ($agent) ? $agent : (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
        $browser = "Other";
        foreach (self::BROWSERS as $key => $value) {
            if (preg_match($key, $agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }
}
