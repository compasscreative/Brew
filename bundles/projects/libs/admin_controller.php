<?php namespace Brew\Bundle\Projects;

use Brew\Bundle\Admin\Secure_Controller;
use Reinink\Deets\Config;
use Reinink\Magick\Magick;
use Reinink\Reveal\Response;
use Reinink\Up\ImageUpload;

class Admin_Controller extends Secure_Controller
{
	public function display_projects()
	{
		return Response::view('projects::admin/index', array
		(
			'projects' => Project::select('id, title, completed_date, show_lo_award, (SELECT COUNT(*) FROM project_photos WHERE project_id = projects.id) AS photos')->order_by('completed_date DESC')->rows()
		));
	}

	public function add_project()
	{
		return Response::view('projects::admin/add');
	}

	public function edit_project($id)
	{
		if ($project = Project::select('id, title, introduction, description, awards, show_lo_award, completed_date')->id($id)->row())
		{
			return Response::view('projects::admin/edit', array
			(
				'project' => $project,
				'photos' => Project_Photo::select('id, section, caption')->project_id($project->id)->rows()
			));
		}
	}

	public function insert_project()
	{
		// Check for required paramaters
		if (!isset($_POST['title']) or
			!isset($_POST['introduction']) or
			!isset($_POST['description']) or
			!isset($_POST['awards']) or
			!isset($_POST['show_lo_award']) or
			!isset($_POST['completed_date']))
		{
			return Response::bad_request();
		}

		// Create the project
		$project = new Project();
		$project->title = trim($_POST['title']);
		$project->introduction = trim($_POST['introduction']);
		$project->description = trim($_POST['description']);
		$project->awards = trim($_POST['awards']);
		$project->show_lo_award = trim($_POST['show_lo_award']);
		$project->completed_date = trim($_POST['completed_date']);
		$project->insert();

		// Return new id
		return Response::json(array('id' => $project->id));
	}

	public function update_project()
	{
		// Check for required paramaters
		if (!isset($_POST['id']) or
			!isset($_POST['title']) or
			!isset($_POST['introduction']) or
			!isset($_POST['description']) or
			!isset($_POST['awards']) or
			!isset($_POST['show_lo_award']) or
			!isset($_POST['completed_date']))
		{
			return Response::bad_request();
		}

		// Load the project
		if (!$project = Project::select($_POST['id']))
		{
			return Response::not_found();
		}

		// Update the project
		$project->id = trim($_POST['id']);
		$project->title = trim($_POST['title']);
		$project->introduction = trim($_POST['introduction']);
		$project->description = trim($_POST['description']);
		$project->awards = trim($_POST['awards']);
		$project->show_lo_award = trim($_POST['show_lo_award']);
		$project->completed_date = trim($_POST['completed_date']);
		$project->update();

		// Update photo order and captions
		if (isset($_POST['photos']))
		{
			$display_order = 1;

			foreach ($_POST['photos'] as $type)
			{
				if (isset($type['seperator']))
				{
					$section = $type['seperator'];
				}
				else if (isset($type['photo']))
				{
					// Get photo id and caption
					$id = key($type['photo']);
					$caption = $type['photo'][$id];

					// Load the photo
					if ($photo = Project_Photo::select($id))
					{
						// Update object
						$photo->caption = trim($caption);
						$photo->section = $section;
						$photo->display_order = $display_order;
						$photo->update();

						// Update display order
						$display_order++;
					}
				}
			}
		}

		// Success
		return true;
	}

	public function delete_project()
	{
		// Check for required paramaters
		if (!isset($_POST['id']))
		{
			return Response::bad_request();
		}

		// Load the project
		if (!$project = Project::select($_POST['id']))
		{
			return Response::not_found();
		}

		// Delete all project photos
		foreach (Project_Photo::select()->project_id($project->id)->rows() as $photo)
		{
			$photo->delete();
		}

		// Delete the project
		$project->delete();

		// Success
		return true;
	}

	public function insert_photo()
	{
		// Check for project id
		if (!isset($_POST['project_id']))
		{
			return Response::bad_request();
		}

		// Load project from database
		if (!$project = Project::select($_POST['project_id']))
		{
			return Response::not_found();
		}

		// Create an image upload handler
		$upload = new ImageUpload(new Magick(Config::get('imagemagick')));

		// Validate uploaded file
		if (!$upload->validate('image'))
		{
			return Response::json(array
			(
				'success' => false,
				'reason' => $upload->error
			));
		}

		// Create new database record
		$project_photo = new Project_Photo();
		$project_photo->project_id = $project->id;
		$project_photo->section = 'Finished';
		$project_photo->display_order = Project_Photo::select('COUNT(*)+1')->project_id($project->id)->field();
		$project_photo->insert();

		// Set project photo folder path
		$folder = STORAGE_PATH . 'projects/photos/' . $project_photo->id . '/';

		// Create new folder
		mkdir($folder);

		// Create various sizes
		$im = new Magick(Config::get('imagemagick'));
		$im->set_file_path($upload->file_path);

		// Xlarge
		if (!$im->set_height(1200)->convert($folder . 'xlarge.jpg'))
		{
			return Response::json(array
			(
				'success' => false,
				'reason' => 'Unable to create xlarge image.'
			));
		}

		// Large
		if (!$im->set_crop_by_ratio(1175/660)->set_height(null)->set_width(1175)->convert($folder . 'large.jpg'))
		{
			return Response::json(array
			(
				'success' => false,
				'reason' => 'Unable to create large image.'
			));
		}

		// Medium
		if (!$im->set_crop_by_ratio(750/500)->set_width(750)->convert($folder . 'medium.jpg'))
		{
			return Response::json(array
			(
				'success' => false,
				'reason' => 'Unable to create medium image.'
			));
		}

		// Small
		if (!$im->set_crop_by_ratio(250/160)->set_width(250)->convert($folder . 'small.jpg'))
		{
			return Response::json(array
			(
				'success' => false,
				'reason' => 'Unable to create small image.'
			));
		}

		// Xsmall
		if (!$im->set_crop_by_ratio(1)->set_width(75)->convert($folder . 'xsmall.jpg'))
		{
			return Response::json(array
			(
				'success' => false,
				'reason' => 'Unable to create xsmall image.'
			));
		}

		// Return success
		return Response::json(array
		(
			'success' => true,
			'id' => $project_photo->id
		));
	}

	public function delete_photo()
	{
		// Check for required paramaters
		if (!isset($_POST['id']))
		{
			return Response::bad_request();
		}

		// Load the photo
		if (!$photo = Project_Photo::select($_POST['id']))
		{
			return Response::not_found();
		}

		// Delete the photo
		$photo->delete();

		// Reorder existing photos
		foreach (Project_Photo::select()->project_id($photo->project_id)->order_by('display_order')->rows() as $key => $photo)
		{
			$photo->display_order = $key + 1;
			$photo->update();
		}

		// Success
		return true;
	}
}