<?php

	namespace Brew\Bundle\Leads;

	use Reinink\Query\DB;
	use Reinink\Utils\Config;

	/*
	|--------------------------------------------------------------------------
	| Create tables
	|--------------------------------------------------------------------------
	*/
		// Leads
		if (!in_array('leads', Config::get('db_tables')))
		{
			DB::query('CREATE TABLE leads (
						id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
						submitted_date TEXT,
						ip_address TEXT,
						name TEXT,
						email TEXT,
						phone TEXT,
						address TEXT,
						interest TEXT,
						budget TEXT,
						message TEXT,
						referral TEXT,
						url TEXT )');
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