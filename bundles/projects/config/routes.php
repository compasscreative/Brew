<?php
namespace Brew\Projects;

use Reinink\Reveal\Response;
use Reinink\Routy\Router;

// Public
Router::get(
    '/projects/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)',
    function ($size, $id) {
        return Response::jpg(STORAGE_PATH . 'projects/photos/' . $id . '/' . $size . '.jpg');
    }
);

// Project pages
Router::get('/admin/projects', 'Brew\Projects\AdminController::displayProjects');
Router::get('/admin/projects/add', 'Brew\Projects\AdminController::addProject');
Router::get('/admin/projects/edit/([0-9]+)', 'Brew\Projects\AdminController::editProject');

// Project actions
Router::post('/admin/projects/insert', 'Brew\Projects\AdminController::insertProject');
Router::post('/admin/projects/update', 'Brew\Projects\AdminController::updateProject');
Router::post('/admin/projects/delete', 'Brew\Projects\AdminController::deleteProject');

// Project photo actions
Router::post('/admin/projects/photos/insert', 'Brew\Projects\AdminController::insertPhoto');
Router::post('/admin/projects/photos/delete', 'Brew\Projects\AdminController::deletePhoto');
