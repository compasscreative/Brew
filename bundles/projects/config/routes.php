<?php
namespace Brew\Projects;

use Reinink\Trailmix\Config;
use Reinink\Routy\Router;

// Public
Router::get(Config::get('projects::base_url'), 'Brew\Projects\PublicController::displayIndex');
Router::get(Config::get('projects::base_url') . '/([0-9]+)/([a-z-0-9]+)', 'Brew\Projects\PublicController::displayProject');
Router::get(Config::get('projects::base_url') . '/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)', 'Brew\Projects\PublicController::displayPhoto');

// Admin: Project Pages
Router::get('/admin/projects', 'Brew\Projects\AdminController::displayProjects');
Router::get('/admin/projects/add', 'Brew\Projects\AdminController::addProject');
Router::get('/admin/projects/edit/([0-9]+)', 'Brew\Projects\AdminController::editProject');

// Admin: Project Actions
Router::post('/admin/projects/insert', 'Brew\Projects\AdminController::insertProject');
Router::post('/admin/projects/update', 'Brew\Projects\AdminController::updateProject');
Router::post('/admin/projects/delete', 'Brew\Projects\AdminController::deleteProject');

// Admin: Project Photo Actions
Router::post('/admin/projects/photos/insert', 'Brew\Projects\AdminController::insertPhoto');
Router::post('/admin/projects/photos/delete', 'Brew\Projects\AdminController::deletePhoto');
