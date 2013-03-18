<?php
namespace Brew\Galleries;

use Reinink\Reveal\Response;
use Reinink\Routy\Router;

// Public
Router::get(
    '/galleries/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)',
    function ($size, $id) {
        return Response::jpg(STORAGE_PATH . 'galleries/photos/' . $id . '/' . $size . '.jpg');
    }
);

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
