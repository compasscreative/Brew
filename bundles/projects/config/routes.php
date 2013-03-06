<?php

	namespace Brew\Bundle\Projects;

	use Reinink\Query\DB;
	use Reinink\Reveal\Response;
	use Reinink\Routy\Router;

	// Public
	Router::get('/projects/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)', function($size, $id)
	{
		// Load project photo
		if (!$photo = DB::row('SELECT id FROM project_photos WHERE id = ?', array($id)))
		{
			return false;
		}

		// Set image path
		$path = STORAGE_PATH . 'projects/photos/' . $photo->id . '/' . $size . '.jpg';

		// Make sure the file exists
		if (!is_file($path))
		{
			return false;
		}

		// Output the image
		return Response::jpg($path);
	});

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