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
			DB::query('projects::table.projects');
		}

		// Project Photos
		if (!in_array('project_photos', Config::get('db_tables')))
		{
			DB::query('projects::table.project_photos');
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