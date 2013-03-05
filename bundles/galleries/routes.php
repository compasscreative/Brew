<?php

	use Reinink\Routy\Router;

	// Gallery pages
	Router::get('/admin/galleries',					'Brew\Bundle\Galleries\Admin_Controller::display_galleries');
	Router::get('/admin/galleries/add',				'Brew\Bundle\Galleries\Admin_Controller::add_gallery');
	Router::get('/admin/galleries/edit/([0-9]+)',	'Brew\Bundle\Galleries\Admin_Controller::edit_gallery');

	// Gallery actions
	Router::post('/admin/galleries/insert',			'Brew\Bundle\Galleries\Admin_Controller::insert_gallery');
	Router::post('/admin/galleries/update',			'Brew\Bundle\Galleries\Admin_Controller::update_gallery');
	Router::post('/admin/galleries/delete',			'Brew\Bundle\Galleries\Admin_Controller::delete_gallery');

	// Gallery photo actions
	Router::post('/admin/galleries/photos/insert',	'Brew\Bundle\Galleries\Admin_Controller::insert_photo');
	Router::post('/admin/galleries/photos/delete',	'Brew\Bundle\Galleries\Admin_Controller::delete_photo');