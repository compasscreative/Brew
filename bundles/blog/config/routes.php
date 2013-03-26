<?php
namespace Brew\Blog;

use Reinink\Reveal\Response;
use Reinink\Routy\Router;
use Reinink\Trailmix\Config;

// Public
Router::get(Config::get('blog::base_url'), 'Brew\Blog\PublicController::displayIndex');
Router::get(Config::get('blog::base_url') . '/([0-9]+)/([a-z-0-9]+)', 'Brew\Blog\PublicController::displayGallery');
Router::get(Config::get('blog::base_url') . '/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)', 'Brew\Blog\PublicController::displayPhoto');

// Admin: Blog Article Pages
Router::get('/admin/blog', 'Brew\Blog\AdminController::redirectToArticles');
Router::get('/admin/blog/articles', 'Brew\Blog\AdminController::displayBlogArticles');
Router::get('/admin/blog/article/add', 'Brew\Blog\AdminController::addBlogArticle');
Router::get('/admin/blog/article/edit/([0-9]+)', 'Brew\Blog\AdminController::editBlogArticle');

// Admin: Blog Article Actions
Router::post('/admin/blog/article/insert', 'Brew\Blog\AdminController::insertBlogArticle');
Router::post('/admin/blog/article/update', 'Brew\Blog\AdminController::updateBlogArticle');
Router::post('/admin/blog/article/delete', 'Brew\Blog\AdminController::deleteBlogArticle');

// Admin: Blog Photo Actions
Router::post('/admin/blog/photos/insert', 'Brew\Blog\AdminController::insertBlogPhoto');
Router::post('/admin/blog/photos/delete', 'Brew\Blog\AdminController::deleteBlogPhoto');

// Admin: Blog Categories Pages
Router::get('/admin/blog/categories', 'Brew\Blog\AdminController::displayBlogCategories');
Router::get('/admin/blog/category/add', 'Brew\Blog\AdminController::addBlogCategory');
Router::get('/admin/blog/category/edit/([0-9]+)', 'Brew\Blog\AdminController::editBlogCategory');

// Admin: Blog Categories Actions
Router::post('/admin/blog/category/insert', 'Brew\Blog\AdminController::insertBlogCategory');
Router::post('/admin/blog/category/update', 'Brew\Blog\AdminController::updateBlogCategory');
Router::post('/admin/blog/category/delete', 'Brew\Blog\AdminController::deleteBlogCategory');
