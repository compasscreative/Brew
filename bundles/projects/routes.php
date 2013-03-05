<?php

	use Reinink\Routy\Router;

	// Project pages
	Router::get('/admin/projects',					'Brew\Bundle\Projects\Admin_Controller::display_projects');
	Router::get('/admin/projects/add',				'Brew\Bundle\Projects\Admin_Controller::add_project');
	Router::get('/admin/projects/edit/([0-9]+)',		'Brew\Bundle\Projects\Admin_Controller::edit_project');

	// Project actions
	Router::post('/admin/projects/insert',			'Brew\Bundle\Projects\Admin_Controller::insert_project');
	Router::post('/admin/projects/update',			'Brew\Bundle\Projects\Admin_Controller::update_project');
	Router::post('/admin/projects/delete',			'Brew\Bundle\Projects\Admin_Controller::delete_project');

	// Project photo actions
	Router::post('/admin/projects/photos/insert',	'Brew\Bundle\Projects\Admin_Controller::insert_photo');
	Router::post('/admin/projects/photos/delete',	'Brew\Bundle\Projects\Admin_Controller::delete_photo');