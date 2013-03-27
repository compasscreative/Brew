<?php
namespace Brew\PackageBuilder;

use Reinink\Trailmix\Config;
use Reinink\Query\DB;

/*
|--------------------------------------------------------------------------
| Create tables
|--------------------------------------------------------------------------
*/

// Package builder options
if (!in_array('package_builder_options', Config::get('db_tables'))) {
    DB::query('packagebuilder::table.package_builder_options');
}

/*
|--------------------------------------------------------------------------
| Setup storage folders
|--------------------------------------------------------------------------
*/

// Bundle folder
if (!is_dir(STORAGE_PATH . 'packagebuilder/')) {
    mkdir(STORAGE_PATH . 'packagebuilder/');
}

// Photos folder
if (!is_dir(STORAGE_PATH . 'packagebuilder/photos/')) {
    mkdir(STORAGE_PATH . 'packagebuilder/photos/');
}

/*
|--------------------------------------------------------------------------
| Setup admin
|--------------------------------------------------------------------------
*/

// Add menu item
Config::$values['admin::menu'][] = array
(
    'name' => 'Package Builder',
    'url' => '/admin/package-builder'
);
