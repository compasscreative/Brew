<?php

	namespace Brew\Bundle\Projects;

	use \Exception;
	use Brew\Bundle\Admin\Secure_Controller;
	use Reinink\Magick\Magick;
	use Reinink\Query\DB;
	use Reinink\Reveal\Response;
	use Reinink\Reveal\View;
	use Reinink\Up\ImageUpload;
	use Reinink\Utils\Config;

	class Admin_Controller extends Secure_Controller
	{
		public function display_projects()
		{
			return View::make('projects::admin/index', array
			(
				'projects' => DB::rows('SELECT id, title, completed_date, show_lo_award, (SELECT COUNT(*) FROM project_photos WHERE project_id = projects.id) AS photos FROM projects ORDER BY completed_date')
			));
		}

		public function add_project()
		{
			return View::make('projects::admin/add');
		}

		public function edit_project($id)
		{
			if ($project = DB::row('SELECT id, title, introduction, description, awards, show_lo_award, completed_date FROM projects WHERE id = ?', array($id)))
			{
				return View::make('projects::admin/edit', array
				(
					'project' => $project,
					'photos' => DB::rows('SELECT id, section, caption FROM project_photos WHERE project_id = ? ORDER BY display_order', array($project->id))
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
				throw new Exception('Missing paramaters.');
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
			echo json_encode(array('id' => $project->id));

			// Success
			return true;
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
				throw new Exception('Missing paramaters.');
			}

			// Load the project
			if (!$project = Project::select($_POST['id']))
			{
				throw new Exception('Project not found.');
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
						if (!$photo = Project_Photo::select($id))
						{
							throw new Exception('Project photo not found.');
						}

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

			// Success
			return true;
		}

		public function delete_project()
		{
			// Check for required paramaters
			if (!isset($_POST['id']))
			{
				throw new Exception('Missing paramaters.');
			}

			// Load the project
			if (!$project = Project::select($_POST['id']))
			{
				throw new Exception('Project not found.');
			}

			// Delete all project photos
			DB::query('DELETE FROM project_photos WHERE project_id = ?', array($project->id));

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
				return false;
			}

			// Load project from database
			if (!$project = Project::select($_POST['project_id']))
			{
				throw new Exception('Project does not exist.');
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
			$project_photo->display_order = DB::value('SELECT COUNT(*)+1 FROM project_photos WHERE project_id = ?', array($project->id));
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
				throw new Exception('Missing paramaters.');
			}

			// Load the photo
			if (!$photo = Project_Photo::select($_POST['id']))
			{
				throw new Exception('Project photo not found.');
			}

			// Delete the photo
			$photo->delete();

			// Reorder existing photos
			foreach (DB::rows('SELECT id FROM project_photos WHERE project_id = ? ORDER BY display_order', array($photo->project_id)) as $key => $row)
			{
				$photo = Project_Photo::select($row->id);
				$photo->display_order = $key + 1;
				$photo->update();
			}

			// Success
			return true;
		}
	}