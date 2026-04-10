<?php

namespace App\Classes;

class AvatarGenerator
{
    public static function gravatar($email = null, $type = "retro", $size = "120x120")
    {
        $avatar = "https://www.gravatar.com/avatar";
        if ($email) {
            $avatar = $avatar . "/" . md5($email);
        }

        return "{$avatar}?d={$type}&size={$size}";
    }

    public static function uiAvatar($name = null, $background = "random", $size = "120x120")
    {
        $avatar = "https://ui-avatars.com/api/?name={$name}&background={$background}&size={$size}";

        return $avatar;
    }
}