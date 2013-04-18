<?php

namespace Brew\Products;

use Reinink\Trailmix\Config;
use Reinink\Query\DB;

/*
|--------------------------------------------------------------------------
| Create tables
|--------------------------------------------------------------------------
*/

// Products
if (!in_array('products', Config::get('db_tables'))) {
    DB::query('products::table.products');
}

// Product Photos
if (!in_array('product_photos', Config::get('db_tables'))) {
    DB::query('products::table.product_photos');
}

/*
|--------------------------------------------------------------------------
| Setup storage folders
|--------------------------------------------------------------------------
*/

// Bundle folder
if (!is_dir(STORAGE_PATH . 'products/')) {
    mkdir(STORAGE_PATH . 'products/');
}

// Photos folder
if (!is_dir(STORAGE_PATH . 'products/photos/')) {
    mkdir(STORAGE_PATH . 'products/photos/');
}

/*
|--------------------------------------------------------------------------
| Setup admin
|--------------------------------------------------------------------------
*/

// Add menu item
Config::$values['admin::menu'][] = array
(
    'name' => 'Products',
    'url' => '/admin/products'
);
