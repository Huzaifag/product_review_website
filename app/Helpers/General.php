<?php

use App\Classes\Country;
use App\Classes\Dotenv;
use App\Classes\SchemaGenerator;
use App\Classes\ThemeManager;
use App\Models\Addon;
use App\Models\AdminNotification;
use App\Models\BusinessNotification;
use App\Models\CaptchaProvider;
use App\Models\Extension;
use App\Models\HomeSection;
use App\Models\Language;
use App\Models\MailTemplate;
use App\Models\PaymentGateway;
use App\Models\Setting;
use App\Models\Translate;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Intervention\Image\Image;

function demoMode()
{
    return config('system.demo_mode');
}

function demo($content = null)
{
    if ($content && config('system.demo_mode')) {
        return d_trans('[Hidden In Demo]');
    }
    return $content;
}

function authUser()
{
    return Auth::user();
}

function authBusinessOwner()
{
    return Auth::guard('business_owner')->user();
}

function businessUrl($path = null)
{
    $url = url(config('system.business.path'));
    if ($path) {
        $url = $url . '/' . $path;
    }
    return $url;
}

function currentBusiness()
{
    $currentBusiness = null;
    if (authBusinessOwner()) {
        $owner = authBusinessOwner();
        $currentBusiness = $owner->businesses()
            ->where('businesses.id', Cookie::get('current_business'))
            ->active()
            ->first();
        if (!$currentBusiness) {
            $currentBusiness = $owner->businesses()->active()->first();
            if ($currentBusiness) {
                Cookie::queue('current_business', $currentBusiness->id, 1440 * 30);
            }
        }
    }

    return $currentBusiness;
}

function businessNotify($businessId, $title, $image, $link = null)
{
    $notification = new BusinessNotification();
    $notification->title = $title;
    $notification->image = $image;
    $notification->link = $link;
    $notification->business_id = $businessId;
    $notification->save();
}

function authAdmin()
{
    return Auth::guard('admin')->user();
}

function adminUrl($path = null)
{
    $url = url(config('system.admin.path'));
    if ($path) {
        $url = $url . '/' . $path;
    }
    return $url;
}

function adminNotify($title, $image, $link = null)
{
    $notification = new AdminNotification();
    $notification->title = $title;
    $notification->image = $image;
    $notification->link = $link;
    $notification->save();
}

function asset_with_version($path)
{
    return asset($path . '?v=' . config('system.item.version'));
}

function setEnv($key, $value, $quote = false)
{
    $env = new Dotenv();
    return $env->setKey($key, $value, $quote);
}

function dateFormat($date, $format = null)
{
    if (!$format) {
        $format = Setting::getAvailableDateFormats()[config('settings.general.date_format')];
    }

    $dateFormat = Carbon::parse($date)->translatedFormat($format);
    return $dateFormat;
}

function numberFormat($number)
{
    $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];
    foreach ($abbrevs as $exponent => $abbrev) {
        if (abs($number) >= pow(10, $exponent)) {
            $display = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && $number % 1000 != 0) ? 1 : 0;
            $number = number_format($display, $decimals) . $abbrev;
            break;
        }
    }
    return $number;
}

function shorterText($text, $chars_limit)
{
    return Str::limit($text, $chars_limit, $end = '...');
}

function purifier($content)
{
    $purifier = new \HTMLPurifier();
    $content = $purifier->purify($content);
    return nl2br(e($content));
}

function getLocale()
{
    return App::getLocale();
}

function getDirection()
{
    return config('app.direction');
}

function languageCacheKey($key, $locale = null)
{
    $locale = $locale ?? getLocale();
    return $key . '_' . $locale;
}

function languages($code = null)
{
    if ($code) {
        return Language::where('code', $code)->first();
    }

    return Language::all();
}

function d_trans($key, $replace = [])
{
    if (config('system.install.complete')) {
        $cache_key = sha1($key . '_dynamic_' . getLocale());

        $translation = Cache::rememberForever('translation_' . $cache_key, function () use ($key) {
            return Translate::dynamic()
                ->where('lang', getLocale())
                ->where('key', $key)
                ->first();
        });

        if (!$translation) {
            $languages = Language::with('translates')->get();
            foreach ($languages as $language) {
                if (!$language->translates->contains('key', $key)) {
                    $translation = new Translate([
                        'key' => $key,
                        'value' => $key,
                        'type' => Translate::TYPE_DYNAMIC,
                        'lang' => $language->code,
                    ]);
                    $translation->save();
                }
            }

            $translation = Translate::where('lang', getLocale())->where('key', $key)->first();
            Cache::forever('translation_' . $cache_key, $translation);
        }

        $translatedText = $translation ? $translation->value ?? $key : $key;
    } else {
        $translatedText = $key;
    }

    foreach ($replace as $placeholder => $value) {
        $translatedText = str_replace(':' . $placeholder, $value, $translatedText);
    }

    return $translatedText;
}

function m_trans($key, $replace = [])
{
    if (config('system.install.complete')) {
        $cache_key = sha1($key . '_manual_' . getLocale());

        $translatedText = Cache::rememberForever('translation_' . $cache_key, function () use ($key) {
            $translation = Translate::manual()
                ->where('lang', getLocale())
                ->where('key', $key)
                ->first();

            return $translation ? $translation->value : $key;
        });
    } else {
        $translatedText = $key;
    }

    foreach ($replace as $placeholder => $value) {
        $translatedText = str_replace(':' . $placeholder, $value, $translatedText);
    }

    return $translatedText;
}

function translate_choice($key, $number, $replace = [])
{
    $translated = d_trans($key, $replace);
    $parts = explode('|', $translated);

    if ($number == 1) {
        $chosen = $parts[0];
    } else {
        $chosen = end($parts);
    }

    $replace['count'] = $number;

    foreach ($replace as $placeholder => $value) {
        $chosen = str_replace(':' . $placeholder, $value, $chosen);
    }

    return $chosen;
}

function pageTitle($env)
{
    $name = m_trans(config('settings.general.site_name'));

    $title = $env->yieldContent('title') ? ' — ' . $env->yieldContent('title') : '';
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false);
    $section = $env->yieldContent('section') ? ' — ' . $env->yieldContent('section') : '';

    return $name . $section . $title;
}

function seoTitle($env)
{
    $name = m_trans(config('settings.general.site_name'));

    $title = $env->yieldContent('title') ? $env->yieldContent('title') : '';
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false);
    $section = $env->yieldContent('section') ? $env->yieldContent('section') : '';

    $seoTitle = $section ? trim($section . ' - ' . $title) : $title;

    if (!empty($seoTitle)) {
        $seoTitle .= ' | ' . $name;
    } else {
        $seoTitle = $name;
    }

    return $seoTitle;
}

function mailTemplate($alias)
{
    return MailTemplate::where('alias', $alias)->active()->first();
}

function extension($alias)
{
    return Extension::where('alias', $alias)->active()->first();
}

function captchaProvider($alias)
{
    return CaptchaProvider::where('alias', $alias)->active()->first();
}

function isAddonActive($alias)
{
    $addon = Addon::where('alias', $alias)->first();
    if ($addon) {
        if ($addon->hasNoStatus() || $addon->isActive()) {
            return true;
        }
    }
    return false;
}

function addonBadge($alias)
{
    if (config('system.demo_mode')) {
        $addon = Addon::where('alias', $alias)->first();
        if ($addon) {
            return '<span class="badge bg-primary py-1 px-2 ms-2"><small>' . d_trans('Addon') . '</small></span>';
        }
    }
    return null;
}

function chartDates($startDate, $endDate, $format = 'Y-m-d')
{
    $dates = collect();
    $startDate = $startDate->copy();
    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        $dates->put($date->translatedFormat($format), 0);
    }
    return $dates;
}

function generateMonthRangeFromDate($date)
{
    $startMonth = Carbon::parse($date)->startOfMonth();
    $currentMonth = Carbon::now()->startOfMonth();
    $months = [];
    while ($startMonth->lte($currentMonth)) {
        $months[] = [
            "key" => $startMonth->format('Y-m'),
            "value" => $startMonth->format('F Y'),
        ];
        $startMonth->addMonth();
    }
    return collect($months)->sortByDesc('key');
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) {
        return $contents;
    } else {
        return false;
    }
}

function urlExists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpCode >= 200 && $httpCode < 400;
}

function getIp()
{
    $ip = null;
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    } else {
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
    }
    return $ip;
}

function countries($code = null)
{
    return $code ? Country::get($code) : Country::all();
}

function hash_encode($id, $length = 12)
{
    $hashids = new Hashids('', $length);
    return $hashids->encode($id);
}

function hash_decode($id, $length = 12)
{
    $hashids = new Hashids('', $length);
    return $hashids->decode($id);
}

function generateUniqueUsername($email = null)
{
    $localPart = $email ? strstr($email, '@', true) : sha1(time());

    $cleanedPart = preg_replace('/[^a-zA-Z]/', '', $localPart);
    $part1 = substr($cleanedPart, 0, 5);
    $part1 = str_pad($part1, 5, 'x');

    $hashPart = substr(md5($localPart . microtime()), 0, 5);

    return strtolower($part1 . $hashPart);
}

function schema($__env, $method = null, $options = [])
{
    return app(SchemaGenerator::class)->render($__env, $method, $options);
}

function activeLink($name, $segment)
{
    return request()->segment($segment) == $name ? 'active' : '';
}

function currentLink($name, $segment)
{
    return request()->segment($segment) == $name ? 'current' : '';
}

function hexToRgb($hex)
{
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return $r . ', ' . $g . ', ' . $b;
}

function removeSpaces($value)
{
    return preg_replace('/\s+/', '', $value);
}

function errorsLayout()
{
    if (config('system.install.complete')) {
        if (request()->segment(1) == config('system.admin.path') && authAdmin()) {
            return 'admin.layouts.errors';
        } else {
            $themeManager = app(ThemeManager::class);
            $themeViewPrefix = $themeManager->getActiveThemeViewPrefix();
            if (request()->segment(1) == config('system.business.path') && authBusinessOwner()) {
                return $themeViewPrefix . '.business.layouts.errors';
            } else {
                return $themeViewPrefix . '.layouts.errors';
            }
        }
    }

    return 'errors.layout';
}

function incrementViews($query, $alias)
{
    $key = sha1($alias);
    $viewed = Cookie::get($key) ? json_decode(Cookie::get($key), true) : [];

    if (!in_array($query->id, $viewed)) {
        $query->increment('views');
        $viewed[] = $query->id;
        Cookie::queue($key, json_encode($viewed), 1440);
    }
}

function price($price)
{
    return number_format($price, 2);
}

function amountFormat($amount, $decimals = 2, $decimalSeparator = '.', $thousandsSeparator = '', $hideNegativeDecimals = false)
{
    if ($hideNegativeDecimals && intval($amount) == $amount) {
        return number_format($amount, 0, $decimalSeparator, $thousandsSeparator);
    }

    return number_format((float) $amount, $decimals, $decimalSeparator, $thousandsSeparator);
}

function getAmount($amount, $decimals = 2, $decimalSeparator = '.', $thousandsSeparator = ',', $hideNegativeDecimals = false)
{
    $amount = amountFormat($amount, $decimals, $decimalSeparator, $thousandsSeparator, $hideNegativeDecimals);

    $symbol = config('settings.currency.symbol');

    if (config('settings.currency.position') == 1) {
        return $symbol . $amount;
    } else {
        return $amount . $symbol;
    }
}

function paymentGateway($alias)
{
    $paymentGateway = PaymentGateway::where('alias', $alias)
        ->active()->first();
    return $paymentGateway;
}

function homeSection($alias)
{
    return Cache::remember("home_section_active_{$alias}",
        now()->addDay(), function () use ($alias) {
            return HomeSection::active()->where('alias', $alias)->first();
        });
}

function cleanURL($url)
{
    $parsed = parse_url($url);

    $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'http';
    $host = $parsed['host'] ?? null;

    if (!$host) {
        $originalUrl = 'http://' . ltrim($url, '/');
        $parsed = parse_url($originalUrl);
        $host = $parsed['host'] ?? null;
        $scheme = $parsed['scheme'] ?? 'http';
    }

    $cleanUrl = $host ? "{$scheme}://{$host}" : null;

    return $cleanUrl;
}

function cleanDomain($url)
{
    if (isset(parse_url($url)['host'])) {
        $parse = str_replace('www.', '', parse_url($url)['host']);
    } else {
        $parse = str_replace('www.', '', $url);
    }

    return preg_replace('/\s+/', '', $parse);
}

function checkTxtRecord($domain, $expectedValue)
{
    try {
        $records = @dns_get_record($domain, DNS_TXT);

        if ($records === false || empty($records)) {
            return false;
        }

        foreach ($records as $record) {
            if (isset($record['txt']) && trim($record['txt']) === trim($expectedValue)) {
                return true;
            }
        }
    } catch (\Exception $e) {
        return false;
    }

    return false;
}
