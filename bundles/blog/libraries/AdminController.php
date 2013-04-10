<?php

namespace Brew\Blog;

use Brew\Admin\SecureController;
use Reinink\Magick\Magick;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Up\ImageUpload;

class AdminController extends SecureController
{
    public function redirectToArticles()
    {
        return Response::redirect('/admin/blog/articles');
    }

    public function displayBlogArticles()
    {
        return Response::view(
            'blog::admin/articles/index',
            [
                'articles' => DB::rows('blog::admin.articles.index')
            ]
        );
    }

    public function addBlogArticle()
    {
        return Response::view(
            'blog::admin/articles/add',
            [
                'categories' => BlogCategory::select('id, name')->orderBy('name')->rows()
            ]
        );
    }

    public function editBlogArticle($id)
    {
        // Load article
        if (!$article = BlogArticle::select('id, category_id, type, title, body, status, published_date')
                              ->where('id', $id)
                              ->row()) {

            Response::notFound();
        }

        // Load categories
        $categories = BlogCategory::select('id, name')
                                  ->orderBy('name')
                                  ->rows();

        // Load photos
        $photos = BlogPhoto::select('id, caption')
                              ->where('article_id', $id)
                              ->orderBy('display_order')
                              ->rows();

        // Display page
        return Response::view(
            'blog::admin/articles/edit',
            [
                'article' => $article,
                'categories' => $categories,
                'photos' => $photos
            ]
        );
    }

    public function insertBlogArticle()
    {
        // Check for required paramaters
        if (!isset($_POST['title']) or
            !isset($_POST['published_date']) or
            !isset($_POST['category_id']) or
            !isset($_POST['type'])) {

            Response::badRequest();
        }

        // Create the article
        $article = new BlogArticle();
        $article->title = trim($_POST['title']);
        $article->published_date = trim($_POST['published_date']);
        $article->category_id = trim($_POST['category_id']);
        $article->type = trim($_POST['type']);
        $article->insert();

        // Return new id
        return Response::json(array('id' => $article->id));
    }

    public function updateBlogArticle()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['title']) or
            !isset($_POST['published_date']) or
            !isset($_POST['status']) or
            !isset($_POST['category_id']) or
            !isset($_POST['body'])) {

            Response::badRequest();
        }

        // Load the article
        if (!$article = BlogArticle::select($_POST['id'])) {
            Response::notFound();
        }

        // Update the article
        $article->title = trim($_POST['title']);
        $article->published_date = trim($_POST['published_date']);
        $article->status = trim($_POST['status']);
        $article->category_id = trim($_POST['category_id']);
        $article->body = trim($_POST['body']);
        $article->update();

        // Update photo order and captions
        if (isset($_POST['photos'])) {

            $display_order = 1;

            foreach ($_POST['photos'] as $id => $caption) {

                if ($photo = BlogPhoto::select($id)) {

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

    public function deleteBlogArticle()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the article
        if (!$article = BlogArticle::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete all blog photos
        foreach (BlogPhoto::select()
                          ->where('article_id', $article->id)
                          ->rows() as $photo) {

            $photo->delete();
        }

        // Delete the article
        $article->delete();

        // Success
        return true;
    }

    public function displayBlogPhoto($id)
    {
        return Response::jpg(STORAGE_PATH . 'blog/photos/' . $id . '/xsmall.jpg');
    }

    public function insertBlogPhoto()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load article from database
        if (!$article = BlogArticle::select($_POST['id'])) {
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
        $photo = new BlogPhoto();
        $photo->article_id = $article->id;
        $photo->display_order = BlogPhoto::select('COUNT(*)+1')
                                         ->where('article_id', $article->id)
                                         ->field();
        $photo->insert();

        // Set article photo folder path
        $folder = STORAGE_PATH . 'blog/photos/' . $photo->id . '/';

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
                'id' => $photo->id,
                'url' => '/admin/blog/photo/' . $photo->id
            )
        );
    }

    public function deleteBlogPhoto()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the photo
        if (!$photo = BlogPhoto::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete the photo
        $photo->delete();

        // Reorder existing photos
        foreach (BlogPhoto::select()
                          ->where('article_id', $photo->article_id)
                          ->orderBy('display_order')
                          ->rows() as $key => $photo) {

            $photo->display_order = $key + 1;
            $photo->update();
        }

        // Success
        return true;
    }

    public function displayBlogCategories()
    {
        return Response::view(
            'blog::admin/categories/index',
            [
                'categories' => BlogCategory::select('id, name')->orderBy('name')->rows()
            ]
        );
    }

    public function addBlogCategory()
    {
        return Response::view('blog::admin/categories/add');
    }

    public function editBlogCategory($id)
    {
        if ($category = BlogCategory::select('id, name')
                              ->where('id', $id)
                              ->row()) {

            return Response::view(
                'blog::admin/categories/edit',
                [
                    'category' => $category
                ]
            );
        }
    }

    public function insertBlogCategory()
    {
        // Check for required paramaters
        if (!isset($_POST['name'])) {
            Response::badRequest();
        }

        // Create the category
        $category = new BlogCategory();
        $category->name = trim($_POST['name']);
        $category->insert();

        // Success
        return true;
    }

    public function updateBlogCategory()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['name'])) {

            Response::badRequest();
        }

        // Load the category
        if (!$category = BlogCategory::select($_POST['id'])) {
            Response::notFound();
        }

        // Update the category
        $category->name = trim($_POST['name']);
        $category->update();

        // Success
        return true;
    }

    public function deleteBlogCategory()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the category
        if (!$category = BlogCategory::select($_POST['id'])) {
            Response::notFound();
        }

        // Update blog articles
        foreach (BlogArticle::select()
                          ->where('category_id', $category->id)
                          ->rows() as $article) {

            $article->category_id = null;
            $article->update();
        }

        // Delete the category
        $category->delete();

        // Success
        return true;
    }
}
