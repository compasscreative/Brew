<?php

	namespace Brew\Bundle\Projects;

	use Reinink\Query\DB;
	use Reinink\Utils\Config;

	/*
	|--------------------------------------------------------------------------
	| Create tables
	|--------------------------------------------------------------------------
	*/
		// Projects
		if (!in_array('projects', Config::get('db_tables')))
		{
			DB::query('CREATE TABLE projects (
						id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
						title TEXT,
						introduction TEXT,
						description TEXT,
						awards TEXT,
						show_lo_award INTEGER,
						completed_date TEXT
						)');
		}

		// Project Photos
		if (!in_array('project_photos', Config::get('db_tables')))
		{
			DB::query('CREATE TABLE project_photos (
						id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
						project_id INTEGER,
						section TEXT,
						caption TEXT,
						display_order INTEGER
						)');
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