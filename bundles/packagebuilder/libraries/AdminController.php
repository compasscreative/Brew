<?php
namespace Brew\PackageBuilder;

use Brew\Admin\SecureController;
use Reinink\Magick\Magick;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Asset;
use Reinink\Trailmix\Config;
use Reinink\Up\ImageUpload;

class AdminController extends SecureController
{
    public function displayOptions()
    {
        // Load options
        $options = PackageBuilderOption::select('id, name, section, small_price_1, small_price_2, medium_price_1, medium_price_2, large_price_1, large_price_2')
                                       ->orderBy('display_order')
                                       ->rows();

        return Response::view('packagebuilder::admin/index', array('options' => $options));
    }

    public function addOption()
    {
        return Response::view(
            'packagebuilder::admin/add',
            [
                'sections' => Config::get('packagebuilder::sections')
            ]
        );
    }

    public function editOption($id)
    {
        if ($option = PackageBuilderOption::select('id, name, section, small_price_1, small_price_2, small_description, medium_price_1, medium_price_2, medium_description, large_price_1, large_price_2, large_description')
                              ->where('id', $id)
                              ->row()) {

            // Set photo folder
            $folder = STORAGE_PATH . 'packagebuilder/photos/' . $option->id . '/';

            // Check if small photo exists
            if (is_file($folder . 'small_small.jpg')) {
                $option->small_photo_url = Config::get('packagebuilder::base_url') . '/photo/small/small/' . $option->id . '/' . filemtime($folder . 'small_small.jpg');
            } else {
                $option->small_photo_url = null;
            }

            // Check if medium photo exists
            if (is_file($folder . 'medium_small.jpg')) {
                $option->medium_photo_url = Config::get('packagebuilder::base_url') . '/photo/small/medium/' . $option->id . '/' . filemtime($folder . 'medium_small.jpg');
            } else {
                $option->medium_photo_url = null;
            }

            // Check if large photo exists
            if (is_file($folder . 'large_small.jpg')) {
                $option->large_photo_url = Config::get('packagebuilder::base_url') . '/photo/small/large/' . $option->id . '/' . filemtime($folder . 'large_small.jpg');
            } else {
                $option->large_photo_url = null;
            }

            // Display page
            return Response::view(
                'packagebuilder::admin/edit',
                [
                    'option' => $option,
                    'sections' => Config::get('packagebuilder::sections')
                ]
            );
        }
    }

    public function insertOption()
    {
        // Check for required paramaters
        if (!isset($_POST['name']) or
            !isset($_POST['section']) or
            !isset($_POST['small_price_1']) or
            !isset($_POST['small_price_2']) or
            !isset($_POST['small_description']) or
            !isset($_POST['medium_price_1']) or
            !isset($_POST['medium_price_2']) or
            !isset($_POST['medium_description']) or
            !isset($_POST['large_price_1']) or
            !isset($_POST['large_price_2']) or
            !isset($_POST['large_description'])) {

            Response::badRequest();
        }

        // Create a new option
        $option = new PackageBuilderOption();
        $option->name = trim($_POST['name']);
        $option->section = trim($_POST['section']);
        $option->small_price_1 = trim($_POST['small_price_1']);
        $option->small_price_2 = trim($_POST['small_price_2']);
        $option->small_description = trim($_POST['small_description']);
        $option->medium_price_1 = trim($_POST['medium_price_1']);
        $option->medium_price_2 = trim($_POST['medium_price_2']);
        $option->medium_description = trim($_POST['medium_description']);
        $option->large_price_1 = trim($_POST['large_price_1']);
        $option->large_price_2 = trim($_POST['large_price_2']);
        $option->large_description = trim($_POST['large_description']);
        $option->insert();

        // Return new id
        return Response::json(array('id' => $option->id));
    }

    public function updateOption()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['name']) or
            !isset($_POST['section']) or
            !isset($_POST['small_price_1']) or
            !isset($_POST['small_price_2']) or
            !isset($_POST['small_description']) or
            !isset($_POST['medium_price_1']) or
            !isset($_POST['medium_price_2']) or
            !isset($_POST['medium_description']) or
            !isset($_POST['large_price_1']) or
            !isset($_POST['large_price_2']) or
            !isset($_POST['large_description'])) {

            Response::badRequest();
        }

        // Load the option
        if (!$option = PackageBuilderOption::select($_POST['id'])) {
            Response::notFound();
        }

        // Update the team member
        $option->name = trim($_POST['name']);
        $option->section = trim($_POST['section']);
        $option->small_price_1 = trim($_POST['small_price_1']);
        $option->small_price_2 = trim($_POST['small_price_2']);
        $option->small_description = trim($_POST['small_description']);
        $option->medium_price_1 = trim($_POST['medium_price_1']);
        $option->medium_price_2 = trim($_POST['medium_price_2']);
        $option->medium_description = trim($_POST['medium_description']);
        $option->large_price_1 = trim($_POST['large_price_1']);
        $option->large_price_2 = trim($_POST['large_price_2']);
        $option->large_description = trim($_POST['large_description']);
        $option->update();

        // Success
        return true;
    }

    public function deleteOption()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the option
        if (!$option = PackageBuilderOption::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete the team member
        $option->delete();

        // Set image folder
        $folder = STORAGE_PATH . 'packagebuilder/photos/' . $option->id . '/';

        // Delete all images
        foreach (array('small_small.jpg', 'small_large.jpg', 'medium_small.jpg', 'medium_large.jpg', 'large_small.jpg', 'large_large.jpg') as $filename) {
            if (is_file($folder . $filename)) {
                unlink($folder . $filename);
            }
        }

        // Delete the folder
        if (is_dir($folder)) {
            rmdir($folder);
        }

        // Success
        return true;
    }

    public function updatePhoto()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['size'])) {

            Response::badRequest();
        }

        // Load the option
        if (!$option = PackageBuilderOption::select($_POST['id'])) {
            Response::notFound();
        }

        // Create an Magick image editor
        $im = new Magick(Config::get('imagemagick'));

        // Create an image upload handler
        $upload = new ImageUpload($im);

        // Validate uploaded file
        if (!$upload->validate('image')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => $upload->error
                )
            );
        }

        // Set photo path
        $folder = STORAGE_PATH . 'packagebuilder/photos/' . $option->id . '/';

        // Create new folder
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        // Large
        if (!$im->setCropByRatio(8/10)
                ->setHeight(1000)
                ->convert($folder . $_POST['size'] . '_large.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create large image.'
                )
            );
        }

        // Small
        if (!$im->setCropByRatio(1)
                ->setHeight(260)
                ->convert($folder . $_POST['size'] . '_small.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create small image.'
                )
            );
        }

        // Return success
        return Response::json(
            array(
                'success' => true,
                'url' => Config::get('packagebuilder::base_url') . '/photo/small/' . $_POST['size'] . '/' . $option->id . '/' . filemtime($folder . $_POST['size'] . '_small.jpg')
            )
        );
    }
}
