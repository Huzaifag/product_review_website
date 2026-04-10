<?php

namespace App\Classes;

class OSDetector
{
    public const OS_SYSTEMS = [
        '/windows nt 11/i' => 'Windows 11',
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/mac os x 10.15/i' => 'Mac OS Catalina',
        '/mac os x 10.14/i' => 'Mac OS Mojave',
        '/mac os x 10.13/i' => 'Mac OS High Sierra',
        '/mac os x 10.12/i' => 'Mac OS Sierra',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/debian/i' => 'Debian',
        '/fedora/i' => 'Fedora',
        '/centos/i' => 'CentOS',
        '/red hat/i' => 'Red Hat',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
        '/windows phone/i' => 'Windows Phone',
        '/symbian/i' => 'Symbian',
        '/chrome os/i' => 'Chrome OS',
        '/bsd/i' => 'BSD',
        '/unix/i' => 'Unix',
    ];

    public static function get($agent = null)
    {
        $os = "Other";
        $agent = ($agent) ? $agent : (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
        foreach (self::OS_SYSTEMS as $key => $value) {
            if (preg_match($key, $agent)) {
                $os = $value;
                break;
            }
        }
        return $os;
    }
}
