<?php
namespace Reinink\Routy;

class Request
{
    public static function secure()
    {
        return !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    }

    public static function ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public static function uri()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);

        return $url['path'];
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function domain()
    {
        return $_SERVER['SERVER_NAME'];
    }
}
