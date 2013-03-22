<?php
namespace Brew\Team;

use Reinink\Trailmix\Config;
use Reinink\Query\DB;

/*
|--------------------------------------------------------------------------
| Create tables
|--------------------------------------------------------------------------
*/

// Team Members
if (!in_array('team_members', Config::get('db_tables'))) {
    DB::query('team::table.team_members');
}

/*
|--------------------------------------------------------------------------
| Setup storage folders
|--------------------------------------------------------------------------
*/

// Bundle folder
if (!is_dir(STORAGE_PATH . 'team/')) {
    mkdir(STORAGE_PATH . 'team/');
}

// Photos folder
if (!is_dir(STORAGE_PATH . 'team/photos/')) {
    mkdir(STORAGE_PATH . 'team/photos/');
}

/*
|--------------------------------------------------------------------------
| Setup admin
|--------------------------------------------------------------------------
*/

// Add menu item
Config::$values['admin::menu'][] = array
(
    'name' => 'Team',
    'url' => '/admin/team'
);
