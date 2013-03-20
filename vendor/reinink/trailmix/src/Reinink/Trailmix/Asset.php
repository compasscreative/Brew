<?php

namespace Reinink\Trailmix;

class Asset
{
    public static $public_path;

    public static function css($url)
    {
        return '<link rel="stylesheet" href="' . self::url($url) . '" />';
    }

    public static function js($url)
    {
        return '<script src="' . self::url($url) . '"></script>';
    }

    public static function url($url)
    {
        if (file_exists(self::$public_path . $url) and $last_updated = filemtime(self::$public_path . $url)) {

            $path = pathinfo($url);

            return $path['dirname'] . '/' . $path['filename'] . '.' . $last_updated . '.' . $path['extension'];

        } else {

            return false;
        }
    }
}
