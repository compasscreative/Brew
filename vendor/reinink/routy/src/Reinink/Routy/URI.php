<?php
namespace Reinink\Routy;

class URI
{
    public static function is($uri, $output = null)
    {
        return preg_match('#^' . $uri . '$#', Request::uri());
    }

    public static function segment($index)
    {
        $segments = self::segments();

        if (isset($segments[$index - 1])) {
            return $segments[$index - 1];
        } else {
            return null;
        }
    }

    public static function segments()
    {
        return explode('/', trim(Request::uri(), '/'));
    }
}
