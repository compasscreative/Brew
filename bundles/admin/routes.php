<?php

	use Reinink\Routy\Router;

	Router::get('/admin',			'Brew\Bundle\Admin\Public_Controller::index');
	Router::get('/admin/login', 	'Brew\Bundle\Admin\Public_Controller::login_form');
	Router::post('/admin/login', 	'Brew\Bundle\Admin\Public_Controller::process_login');
	Router::get('/admin/logout',	'Brew\Bundle\Admin\Public_Controller::process_logout');