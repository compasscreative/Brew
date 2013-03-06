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
			DB::query('galleries::table.galleries');
		}

		// Gallery Photos
		if (!in_array('gallery_photos', Config::get('db_tables')))
		{
			DB::query('galleries::table.gallery_photos');
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