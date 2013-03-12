<?php namespace Brew\Bundle\Galleries;

use Reinink\Deets\Config;
use Reinink\Query\DB;

/*
|--------------------------------------------------------------------------
| Create tables
|--------------------------------------------------------------------------
*/
	// Galleries
	if (!in_array('galleries', Config::get('db_tables')))
	{
		DB::query('galleries::table.galleries');
	}

	// Gallery Photos
	if (!in_array('gallery_photos', Config::get('db_tables')))
	{
		DB::query('galleries::table.gallery_photos');
	}


/*
|--------------------------------------------------------------------------
| Setup storage folders
|--------------------------------------------------------------------------
*/

	// Bundle folder
	if (!is_dir(STORAGE_PATH . 'galleries/'))
	{
		mkdir(STORAGE_PATH . 'galleries/');
	}

	// Photos folder
	if (!is_dir(STORAGE_PATH . 'galleries/photos/'))
	{
		mkdir(STORAGE_PATH . 'galleries/photos/');
	}


/*
|--------------------------------------------------------------------------
| Setup admin
|--------------------------------------------------------------------------
*/

	// Add menu item
	Config::$values['admin::menu'][] = array
	(
		'name' => 'Galleries',
		'url' => '/admin/galleries'
	);