<?php

namespace Brew\Products;

use Brew\Admin\SecureController;
use Reinink\Trailmix\Config;
use Reinink\Magick\Magick;
use Reinink\Reveal\Response;
use Reinink\Up\ImageUpload;

class AdminController extends SecureController
{
    public function displayProducts()
    {
        return Response::view(
            'products::admin/index',
            [
                'products' => Product::select('id, title, (SELECT COUNT(*) FROM product_photos WHERE product_id = products.id) AS photos')
                                     ->orderBy('display_order')
                                     ->rows()
            ]
        );
    }

    public function addProduct()
    {
        return Response::view('products::admin/add');
    }

    public function editProduct($id)
    {
        // Load product
        if (!$product = Product::select('id, title, introduction, description, title_tag, description_tag')
                               ->where('id', $id)
                               ->row()) {

            Response::notFound();
        }

        // Load proudct photos
        $photos = ProductPhoto::select('id, caption')
                              ->where('product_id', $id)
                              ->orderBy('display_order')
                              ->rows();

        // Return view
        return Response::view(
            'products::admin/edit',
            [
                'product' => $product,
                'photos' => $photos
            ]
        );
    }

    public function insertProduct()
    {
        // Check for required paramaters
        if (!isset($_POST['title']) or
            !isset($_POST['introduction']) or
            !isset($_POST['description']) or
            !isset($_POST['title_tag']) or
            !isset($_POST['description_tag'])) {

            Response::badRequest();
        }

        // Create the product
        $product = new Product();
        $product->title = trim($_POST['title']);
        $product->introduction = trim($_POST['introduction']);
        $product->description = trim($_POST['description']);
        $product->title_tag = trim($_POST['title_tag']);
        $product->description_tag = trim($_POST['description_tag']);
        $product->display_order = Product::select('COUNT(*)+1')->field();
        $product->insert();

        // Return new id
        return Response::json(
            [
                'id' => $product->id
            ]
        );
    }

    public function updateProduct()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['title']) or
            !isset($_POST['introduction']) or
            !isset($_POST['description']) or
            !isset($_POST['title_tag']) or
            !isset($_POST['description_tag'])) {

            Response::badRequest();
        }

        // Load the product
        if (!$product = Product::select($_POST['id'])) {
            Response::notFound();
        }

        // Update the product
        $product->title = trim($_POST['title']);
        $product->introduction = trim($_POST['introduction']);
        $product->description = trim($_POST['description']);
        $product->title_tag = trim($_POST['title_tag']);
        $product->description_tag = trim($_POST['description_tag']);
        $product->update();

        // Update photo order and captions
        if (isset($_POST['photos'])) {

            $display_order = 1;

            foreach ($_POST['photos'] as $id => $caption) {

                if ($photo = ProductPhoto::select($id)) {

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

    public function updateProductOrder()
    {
        // Check for required paramaters
        if (!isset($_POST['products'])) {
            Response::badRequest();
        }

        // Update product display orders
        foreach (explode(',', $_POST['products']) as $display_order => $id) {
            if ($product = Product::select($id)) {
                $product->display_order = $display_order + 1;
                $product->update();
            }
        }

        // Success
        return true;
    }

    public function deleteProduct()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the product
        if (!$product = Product::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete all product photos
        foreach (ProductPhoto::select()
                             ->where('product_id', $product->id)
                             ->rows() as $photo) {

            // Set image folder
            $folder = STORAGE_PATH . 'products/photos/' . $photo->id . '/';

            // Delete all images
            foreach (['xlarge.jpg', 'large.jpg', 'medium.jpg', 'small.jpg', 'xsmall.jpg'] as $filename) {
                if (is_file($folder . $filename)) {
                    unlink($folder . $filename);
                }
            }

            // Delete the folder
            if (is_dir($folder)) {
                rmdir($folder);
            }

            // Delete the photo
            $photo->delete();
        }

        // Delete the product
        $product->delete();

        // Reorder remaining products
        foreach (Product::select()
                        ->orderBy('display_order')
                        ->rows() as $key => $product) {

            $product->display_order = $key + 1;
            $product->update();
        }

        // Success
        return true;
    }

    public function displayPhoto($id)
    {
        return Response::jpg(STORAGE_PATH . 'products/photos/' . $id . '/xsmall.jpg');
    }

    public function insertPhoto()
    {
        // Check for product id
        if (!isset($_POST['product_id'])) {
            Response::badRequest();
        }

        // Load product from database
        if (!$product = Product::select($_POST['product_id'])) {
            Response::notFound();
        }

        // Create an image upload handler
        $upload = new ImageUpload(new Magick(Config::get('imagemagick')));

        // Validate uploaded file
        if (!$upload->validate('image')) {
            return Response::json(
                [
                    'success' => false,
                    'reason' => $upload->error
                ]
            );
        }

        // Create new database record
        $product_photo = new ProductPhoto();
        $product_photo->product_id = $product->id;
        $product_photo->display_order = ProductPhoto::select('COUNT(*)+1')
                                                    ->where('product_id', $product->id)
                                                    ->field();
        $product_photo->insert();

        // Set product photo folder path
        $folder = STORAGE_PATH . 'products/photos/' . $product_photo->id . '/';

        // Create new folder
        mkdir($folder);

        // Create various sizes
        $im = new Magick(Config::get('imagemagick'));
        $im->setFilePath($upload->file_path);

        // Xlarge
        if (!$im->setHeight(1200)
                ->convert($folder . 'xlarge.jpg')) {
            return Response::json(
                [
                    'success' => false,
                    'reason' => 'Unable to create xlarge image.'
                ]
            );
        }

        // Large
        if (!$im->setCropByRatio(1175/660)
                ->setHeight(null)
                ->setWidth(1175)
                ->convert($folder . 'large.jpg')) {
            return Response::json(
                [
                    'success' => false,
                    'reason' => 'Unable to create large image.'
                ]
            );
        }

        // Medium
        if (!$im->setCropByRatio(750/500)
                ->setWidth(750)
                ->convert($folder . 'medium.jpg')) {
            return Response::json(
                [
                    'success' => false,
                    'reason' => 'Unable to create medium image.'
                ]
            );
        }

        // Small
        if (!$im->setCropByRatio(250/160)
                ->setWidth(250)
                ->convert($folder . 'small.jpg')) {
            return Response::json(
                [
                    'success' => false,
                    'reason' => 'Unable to create small image.'
                ]
            );
        }

        // Xsmall
        if (!$im->setCropByRatio(1)
                ->setWidth(75)
                ->convert($folder . 'xsmall.jpg')) {
            return Response::json(
                [
                    'success' => false,
                    'reason' => 'Unable to create xsmall image.'
                ]
            );
        }

        // Return success
        return Response::json(
            [
                'success' => true,
                'id' => $product_photo->id,
                'url' => '/admin/products/photo/' . $product_photo->id
            ]
        );
    }

    public function deletePhoto()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the photo
        if (!$photo = ProductPhoto::select($_POST['id'])) {
            Response::notFound();
        }

        // Set image folder
        $folder = STORAGE_PATH . 'products/photos/' . $photo->id . '/';

        // Delete all images
        foreach (['xlarge.jpg', 'large.jpg', 'medium.jpg', 'small.jpg', 'xsmall.jpg'] as $filename) {
            if (is_file($folder . $filename)) {
                unlink($folder . $filename);
            }
        }

        // Delete the folder
        if (is_dir($folder)) {
            rmdir($folder);
        }

        // Delete the photo
        $photo->delete();

        // Reorder remaining photos
        foreach (ProductPhoto::select()
                             ->where('product_id', $photo->product_id)
                             ->orderBy('display_order')
                             ->rows() as $key => $photo) {

            $photo->display_order = $key + 1;
            $photo->update();
        }

        // Success
        return true;
    }
}
