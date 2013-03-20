<?php
namespace Brew\Projects;

use Reinink\Trailmix\Config;
use Reinink\Query\DB;

/*
|--------------------------------------------------------------------------
| Create tables
|--------------------------------------------------------------------------
*/

// Projects
if (!in_array('projects', Config::get('db_tables'))) {
    DB::query('projects::table.projects');
}

// Project Photos
if (!in_array('project_photos', Config::get('db_tables'))) {
    DB::query('projects::table.project_photos');
}

/*
|--------------------------------------------------------------------------
| Setup storage folders
|--------------------------------------------------------------------------
*/

// Bundle folder
if (!is_dir(STORAGE_PATH . 'projects/')) {
    mkdir(STORAGE_PATH . 'projects/');
}

// Photos folder
if (!is_dir(STORAGE_PATH . 'projects/photos/')) {
    mkdir(STORAGE_PATH . 'projects/photos/');
}

/*
|--------------------------------------------------------------------------
| Setup admin
|--------------------------------------------------------------------------
*/

// Add menu item
Config::$values['admin::menu'][] = array
(
    'name' => 'Projects',
    'url' => '/admin/projects'
);
