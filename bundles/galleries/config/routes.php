<?php
namespace Brew\Galleries;

use Reinink\Trailmix\Config;
use Reinink\Routy\Router;

// Public
Router::get(Config::get('galleries::base_url'), 'Brew\Galleries\PublicController::displayIndex');
Router::get(Config::get('galleries::base_url') . '/([0-9]+)/([a-z-0-9]+)', 'Brew\Galleries\PublicController::displayGallery');
Router::get(Config::get('galleries::base_url') . '/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)', 'Brew\Galleries\PublicController::displayPhoto');

// Gallery pages
Router::get('/admin/galleries', 'Brew\Galleries\AdminController::displayGalleries');
Router::get('/admin/galleries/add', 'Brew\Galleries\AdminController::addGallery');
Router::get('/admin/galleries/edit/([0-9]+)', 'Brew\Galleries\AdminController::editGallery');

// Gallery actions
Router::post('/admin/galleries/insert', 'Brew\Galleries\AdminController::insertGallery');
Router::post('/admin/galleries/update', 'Brew\Galleries\AdminController::updateGallery');
Router::post('/admin/galleries/delete', 'Brew\Galleries\AdminController::deleteGallery');

// Gallery photo actions
Router::post('/admin/galleries/photos/insert', 'Brew\Galleries\AdminController::insertPhoto');
Router::post('/admin/galleries/photos/delete', 'Brew\Galleries\AdminController::deletePhoto');
