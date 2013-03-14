<?php namespace Brew\Bundle\Galleries;

use Brew\Bundle\Admin\Secure_Controller;
use Reinink\Deets\Config;
use Reinink\Magick\Magick;
use Reinink\Reveal\Response;
use Reinink\Up\ImageUpload;

class Admin_Controller extends Secure_Controller
{
	public function display_galleries()
	{
		return Response::view('galleries::admin/index', array
		(
			'galleries' => Gallery::select('id, title, priority, (SELECT COUNT(*) FROM gallery_photos WHERE gallery_id = galleries.id) AS photos')->order_by('priority, title')->rows()
		));
	}

	public function add_gallery()
	{
		return Response::view('galleries::admin/add');
	}

	public function edit_gallery($id)
	{
		if ($gallery = Gallery::select('id, title, priority, description')->id($id)->row())
		{
			return Response::view('galleries::admin/edit', array
			(
				'gallery' => $gallery,
				'photos' => Gallery_Photo::select('id, caption')->gallery_id($id)->order_by('display_order')->rows()
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
			Response::bad_request();
		}

		// Create the gallery
		$gallery = new Gallery();
		$gallery->title = trim($_POST['title']);
		$gallery->description = trim($_POST['description']);
		$gallery->priority = trim($_POST['priority']);
		$gallery->insert();

		// Return new id
		return Response::json(array('id' => $gallery->id));
	}

	public function update_gallery()
	{
		// Check for required paramaters
		if (!isset($_POST['id']) or
			!isset($_POST['title']) or
			!isset($_POST['description']) or
			!isset($_POST['priority']))
		{
			Response::bad_request();
		}

		// Load the gallery
		if (!$gallery = Gallery::select($_POST['id']))
		{
			Response::not_found();
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
				if ($photo = Gallery_Photo::select($id))
				{
					// Update object
					$photo->caption = trim($caption);
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

	public function delete_gallery()
	{
		// Check for required paramaters
		if (!isset($_POST['id']))
		{
			Response::bad_request();
		}

		// Load the gallery
		if (!$gallery = Gallery::select($_POST['id']))
		{
			Response::not_found();
		}

		// Delete all gallery photos
		foreach (Gallery_Photo::select()->gallery_id($gallery->id)->rows() as $photo)
		{
			$photo->delete();
		}

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
			Response::bad_request();
		}

		// Load gallery from database
		if (!$gallery = Gallery::select($_POST['gallery_id']))
		{
			Response::not_found();
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
		$gallery_photo->display_order = Gallery_Photo::select('COUNT(*)+1')->gallery_id($gallery->id)->field();
		$gallery_photo->insert();

		// Set gallery photo folder path
		$folder = STORAGE_PATH . 'galleries/photos/' . $gallery_photo->id . '/';

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
			Response::bad_request();
		}

		// Load the photo
		if (!$photo = Gallery_Photo::select($_POST['id']))
		{
			Response::not_found();
		}

		// Delete the photo
		$photo->delete();

		// Reorder existing photos
		foreach (Gallery_Photo::select()->gallery_id($photo->gallery_id)->order_by('display_order')->rows() as $key => $photo)
		{
			$photo->display_order = $key + 1;
			$photo->update();
		}

		// Success
		return true;
	}
}