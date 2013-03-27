<?php
namespace Brew\Blog;

use Reinink\Trailmix\Config;

/*
|--------------------------------------------------------------------------
| Base route
|--------------------------------------------------------------------------
*/

Config::set('blog::base_url', '/blog');

/*
|--------------------------------------------------------------------------
| Views
|--------------------------------------------------------------------------
*/

Config::set(
    'blog::views',
    [
        'index' => 'blog::index',
        'article' => 'blog::article',
        'category' => 'blog::category',
        'search' => 'blog::search',
        'sidebar' => 'blog::sidebar'
    ]
);