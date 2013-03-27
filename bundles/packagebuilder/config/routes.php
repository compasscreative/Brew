<?php
namespace Brew\PackageBuilder;

use Reinink\Trailmix\Config;
use Reinink\Routy\Router;

// Public
Router::get(Config::get('packagebuilder::base_url'), 'Brew\PackageBuilder\PublicController::displayIndex');
Router::get(Config::get('packagebuilder::base_url') . '/photo/(large|small)/(small|medium|large)/([0-9]+)/[0-9]+', 'Brew\PackageBuilder\PublicController::displayPhoto');

// Admin: Pages
Router::get('/admin/package-builder', 'Brew\PackageBuilder\AdminController::displayOptions');
Router::get('/admin/package-builder/add', 'Brew\PackageBuilder\AdminController::addOption');
Router::get('/admin/package-builder/edit/([0-9]+)', 'Brew\PackageBuilder\AdminController::editOption');

// Admin: Actions
Router::post('/admin/package-builder/insert', 'Brew\PackageBuilder\AdminController::insertOption');
Router::post('/admin/package-builder/update', 'Brew\PackageBuilder\AdminController::updateOption');
Router::post('/admin/package-builder/order', 'Brew\PackageBuilder\AdminController::updateOptionOrder');
Router::post('/admin/package-builder/delete', 'Brew\PackageBuilder\AdminController::deleteOption');
Router::post('/admin/package-builder/update-photo', 'Brew\PackageBuilder\AdminController::updatePhoto');
