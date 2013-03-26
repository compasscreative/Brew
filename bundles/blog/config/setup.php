<?php
namespace Brew\Galleries;

use Reinink\Trailmix\Config;
use Reinink\Query\DB;

/*
|--------------------------------------------------------------------------
| Create tables
|--------------------------------------------------------------------------
*/

// Blog Articles
if (!in_array('blog_articles', Config::get('db_tables'))) {
    DB::query('blog::table.blog_articles');
}

// Blog Photos
if (!in_array('blog_photos', Config::get('db_tables'))) {
    DB::query('blog::table.blog_photos');
}

// Blog Categories
if (!in_array('blog_categories', Config::get('db_tables'))) {
    DB::query('blog::table.blog_categories');
}

/*
|--------------------------------------------------------------------------
| Setup storage folders
|--------------------------------------------------------------------------
*/

// Bundle folder
if (!is_dir(STORAGE_PATH . 'blog/')) {
    mkdir(STORAGE_PATH . 'blog/');
}

// Photos folder
if (!is_dir(STORAGE_PATH . 'blog/photos/')) {
    mkdir(STORAGE_PATH . 'blog/photos/');
}

/*
|--------------------------------------------------------------------------
| Setup admin
|--------------------------------------------------------------------------
*/

// Add menu item
Config::$values['admin::menu'][] = array
(
    'name' => 'Blog',
    'url' => '/admin/blog'
);
