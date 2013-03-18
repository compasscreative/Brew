<?php
namespace Brew\Leads;

use Reinink\Deets\Config;
use Reinink\Query\DB;

/*
|--------------------------------------------------------------------------
| Create tables
|--------------------------------------------------------------------------
*/
// Leads
if (!in_array('leads', Config::get('db_tables'))) {
    DB::query('leads::table.leads');
}

/*
|--------------------------------------------------------------------------
| Setup admin
|--------------------------------------------------------------------------
*/

// Add menu item
Config::$values['admin::menu'][] = array
(
    'name' => 'Leads',
    'url' => '/admin/leads'
);
