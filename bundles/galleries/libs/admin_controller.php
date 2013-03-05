<?php

	namespace Brew\Bundle\Galleries;

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
		public function display_galleries()
		{
			return View::make('galleries::admin/index', array
			(
				'galleries' => DB::rows('SELECT id, title, priority, (SELECT COUNT(*) FROM gallery_photos WHERE gallery_id = galleries.id) AS photos FROM galleries ORDER BY priority, title')
			));
		}

		public function add_gallery()
		{
			return View::make('galleries::admin/add');
		}

		public function edit_gallery($id)
		{
			if ($gallery = DB::row('SELECT id, title, priority, description FROM galleries WHERE id = ?', array($id)))
			{
				return View::make('galleries::admin/edit', array
				(
					'gallery' => $gallery,
					'photos' => DB::rows('SELECT id, caption FROM gallery_photos WHERE gallery_id = ? ORDER BY display_order', array($gallery->id))
				));
			}
		}

		public function insert_gallery()
		{
			// Check for required paramaters
			if (!isset($_POST['title']) or
				!isset($_POST['description']) or
				!isset($_POST['priority']))
			{
				throw new Exception('Missing paramaters.');
			}

			// Create the gallery
			$gallery = new Gallery();
			$gallery->title = trim($_POST['title']);
			$gallery->description = trim($_POST['description']);
			$gallery->priority = trim($_POST['priority']);
			$gallery->insert();

			// Return new id
			echo json_encode(array('id' => $gallery->id));

			// Success
			return true;
		}

		public function update_gallery()
		{
			// Check for required paramaters
			if (!isset($_POST['id']) or
				!isset($_POST['title']) or
				!isset($_POST['description']) or
				!isset($_POST['priority']))
			{
				throw new Exception('Missing paramaters.');
			}

			// Load the gallery
			if (!$gallery = Gallery::select($_POST['id']))
			{
				throw new Exception('Gallery not found.');
			}

			// Update the gallery
			$gallery->id = trim($_POST['id']);
			$gallery->title = trim($_POST['title']);
			$gallery->description = trim($_POST['description']);
			$gallery->priority = trim($_POST['priority']);
			$gallery->update();

			// Update photo order and captions
			if (isset($_POST['photos']))
			{
				$display_order = 1;

				foreach ($_POST['photos'] as $id => $caption)
				{
					// Load the photo
					if (!$photo = Gallery_Photo::select($id))
					{
						throw new Exception('Gallery photo not found.');
					}

					// Update object
					$photo->caption = trim($caption);
					$photo->display_order = $display_order;
					$photo->update();

					// Update display order
					$display_order++;
				}
			}

			// Success
			return true;
		}

		public function delete_gallery()
		{
			// Check for required paramaters
			if (!isset($_POST['id']))
			{
				throw new Exception('Missing paramaters.');
			}

			// Load the gallery
			if (!$gallery = Gallery::select($_POST['id']))
			{
				throw new Exception('Gallery not found.');
			}

			// Delete all gallery photos
			DB::query('DELETE FROM gallery_photos WHERE gallery_id = ?', array($gallery->id));

			// Delete the gallery
			$gallery->delete();

			// Success
			return true;
		}

		public function insert_photo()
		{
			// Check for gallery id
			if (!isset($_POST['gallery_id']))
			{
				return false;
			}

			// Load gallery from database
			if (!$gallery = Gallery::select($_POST['gallery_id']))
			{
				throw new Exception('Gallery does not exist.');
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
			$gallery_photo = new Gallery_Photo();
			$gallery_photo->gallery_id = $gallery->id;
			$gallery_photo->display_order = DB::value('SELECT COUNT(*)+1 FROM gallery_photos WHERE gallery_id = ?', array($gallery->id));
			$gallery_photo->insert();

			// Set gallery photo folder path
			$folder = Config::get('storage_path') . 'gallery_photos/' . $gallery_photo->id . '/';

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
				'id' => $gallery_photo->id
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
			if (!$photo = Gallery_Photo::select($_POST['id']))
			{
				throw new Exception('Gallery photo not found.');
			}

			// Delete the photo
			$photo->delete();

			// Reorder existing photos
			foreach (DB::rows('SELECT id FROM gallery_photos WHERE gallery_id = ? ORDER BY display_order', array($photo->gallery_id)) as $key => $row)
			{
				$photo = Gallery_Photo::select($row->id);
				$photo->display_order = $key + 1;
				$photo->update();
			}

			// Success
			return true;
		}
	}