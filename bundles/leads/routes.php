<?php

	use Reinink\Routy\Router;

	// Public
	Router::post('/leads/submit',					'Brew\Bundle\Leads\Public_Controller::process');

	// Admin
	Router::get('/admin/leads',						'Brew\Bundle\Leads\Admin_Controller::index');
	Router::get('/admin/leads/edit/([0-9]+)',		'Brew\Bundle\Leads\Admin_Controller::edit');
	Router::post('/admin/leads/delete',				'Brew\Bundle\Leads\Admin_Controller::delete');