<?php
namespace Brew\Galleries;

use Brew\Admin\SecureController;
use Reinink\Trailmix\Config;
use Reinink\Magick\Magick;
use Reinink\Reveal\Response;
use Reinink\Up\ImageUpload;

class AdminController extends SecureController
{
    public function displayGalleries()
    {
        $galleries = Gallery::select('id, title, priority, (SELECT COUNT(*) FROM gallery_photos WHERE gallery_id = galleries.id) AS photos')
                            ->orderBy('priority, title')
                            ->rows();

        return Response::view('galleries::admin/index', array('galleries' => $galleries));
    }

    public function addGallery()
    {
        return Response::view('galleries::admin/add');
    }

    public function editGallery($id)
    {
        if (!$gallery = Gallery::select('id, title, priority, description')
                              ->where('id', $id)
                              ->row()) {

            Response::notFound();
        }

        $photos = GalleryPhoto::select('id, caption')
                              ->where('gallery_id', $id)
                              ->orderBy('display_order')
                              ->rows();

        return Response::view('galleries::admin/edit', array('gallery' => $gallery, 'photos' => $photos));
    }

    public function insertGallery()
    {
        // Check for required paramaters
        if (!isset($_POST['title']) or
            !isset($_POST['description']) or
            !isset($_POST['priority'])) {

            Response::badRequest();
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

    public function updateGallery()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['title']) or
            !isset($_POST['description']) or
            !isset($_POST['priority'])) {

            Response::badRequest();
        }

        // Load the gallery
        if (!$gallery = Gallery::select($_POST['id'])) {
            Response::notFound();
        }

        // Update the gallery
        $gallery->id = trim($_POST['id']);
        $gallery->title = trim($_POST['title']);
        $gallery->description = trim($_POST['description']);
        $gallery->priority = trim($_POST['priority']);
        $gallery->update();

        // Update photo order and captions
        if (isset($_POST['photos'])) {

            $display_order = 1;

            foreach ($_POST['photos'] as $id => $caption) {

                if ($photo = GalleryPhoto::select($id)) {

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

    public function deleteGallery()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the gallery
        if (!$gallery = Gallery::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete all gallery photos
        foreach (GalleryPhoto::select()
                             ->where('gallery_id', $gallery->id)
                             ->rows() as $photo) {

            $photo->delete();
        }

        // Delete the gallery
        $gallery->delete();

        // Success
        return true;
    }

    public function insertPhoto()
    {
        // Check for gallery id
        if (!isset($_POST['gallery_id'])) {
            Response::badRequest();
        }

        // Load gallery from database
        if (!$gallery = Gallery::select($_POST['gallery_id'])) {
            Response::notFound();
        }

        // Create an image upload handler
        $upload = new ImageUpload(new Magick(Config::get('imagemagick')));

        // Validate uploaded file
        if (!$upload->validate('image')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => $upload->error
                )
            );
        }

        // Create new database record
        $gallery_photo = new GalleryPhoto();
        $gallery_photo->gallery_id = $gallery->id;
        $gallery_photo->display_order = GalleryPhoto::select('COUNT(*)+1')
                                                    ->where('gallery_id', $gallery->id)
                                                    ->field();
        $gallery_photo->insert();

        // Set gallery photo folder path
        $folder = STORAGE_PATH . 'galleries/photos/' . $gallery_photo->id . '/';

        // Create new folder
        mkdir($folder);

        // Create various sizes
        $im = new Magick(Config::get('imagemagick'));
        $im->setFilePath($upload->file_path);

        // Xlarge
        if (!$im->setHeight(1200)
                ->convert($folder . 'xlarge.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create xlarge image.'
                )
            );
        }

        // Large
        if (!$im->setCropByRatio(1175/660)
                ->setHeight(null)
                ->setWidth(1175)
                ->convert($folder . 'large.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create large image.'
                )
            );
        }

        // Medium
        if (!$im->setCropByRatio(750/500)
                ->setWidth(750)
                ->convert($folder . 'medium.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create medium image.'
                )
            );
        }

        // Small
        if (!$im->setCropByRatio(250/160)
                ->setWidth(250)
                ->convert($folder . 'small.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create small image.'
                )
            );
        }

        // Xsmall
        if (!$im->setCropByRatio(1)
                ->setWidth(75)
                ->convert($folder . 'xsmall.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create xsmall image.'
                )
            );
        }

        // Return success
        return Response::json(
            array(
                'success' => true,
                'id' => $gallery_photo->id,
                'url' => Config::get('galleries::base_url') . '/photo/xsmall/' . $gallery_photo->id
            )
        );
    }

    public function deletePhoto()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the photo
        if (!$photo = GalleryPhoto::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete the photo
        $photo->delete();

        // Reorder existing photos
        foreach (GalleryPhoto::select()
                             ->where('gallery_id', $photo->gallery_id)
                             ->orderBy('display_order')
                             ->rows() as $key => $photo) {

            $photo->display_order = $key + 1;
            $photo->update();
        }

        // Success
        return true;
    }
}
