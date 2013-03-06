<?php

	namespace Brew\Bundle\Galleries;

	use Reinink\Query\DB;
	use Reinink\Utils\Config;

	/*
	|--------------------------------------------------------------------------
	| Create tables
	|--------------------------------------------------------------------------
	*/
		// Galleries
		if (!in_array('galleries', Config::get('db_tables')))
		{
			DB::query('CREATE TABLE galleries (
						id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
						title TEXT,
						description TEXT,
						priority INTEGER )');
		}

		// Gallery Photos
		if (!in_array('gallery_photos', Config::get('db_tables')))
		{
			DB::query('CREATE TABLE gallery_photos (
						id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
						gallery_id INTEGER,
						caption TEXT,
						display_order INTEGER )');
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