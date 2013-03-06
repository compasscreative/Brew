<?php

	namespace Brew\Bundle\Leads;

	use Reinink\Utils\Config;

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