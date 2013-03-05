<?php

	use Brew\Bundle\Leads\Form;
	use Reinink\Utils\Config;

	/*
	|--------------------------------------------------------------------------
	| Bundle setup
	|--------------------------------------------------------------------------
	*/

		// Add admin menu item
		Config::$values['admin::menu'][] = array
		(
			'name' => 'Leads',
			'url' => '/admin/leads'
		);


	/*
	|--------------------------------------------------------------------------
	| Form definitions
	|--------------------------------------------------------------------------
	*/

		// Contact form
		Config::$values['leads::forms']['contact'] = new Form('From Name', 'info@example.com', array('info@example.com'));
		Config::$values['leads::forms']['contact']->enable_name(true);
		Config::$values['leads::forms']['contact']->enable_email(true);
		Config::$values['leads::forms']['contact']->enable_phone();
		Config::$values['leads::forms']['contact']->enable_address();
		Config::$values['leads::forms']['contact']->enable_message();