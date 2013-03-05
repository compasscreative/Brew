<?php

	use Reinink\Utils\Config;

	// Set default menu items
	Config::$values['admin::menu'][] = array
	(
		'name' => 'Projects',
		'url' => '/admin/projects'
	);