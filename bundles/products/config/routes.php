<?php

namespace Brew\Products;

use Reinink\Routy\Router;

// Admin: Product Pages
Router::get('/admin/products', 'Brew\Products\AdminController::displayProducts');
Router::get('/admin/products/add', 'Brew\Products\AdminController::addProduct');
Router::get('/admin/products/edit/([0-9]+)', 'Brew\Products\AdminController::editProduct');

// Admin: Product Actions
Router::post('/admin/products/insert', 'Brew\Products\AdminController::insertProduct');
Router::post('/admin/products/update', 'Brew\Products\AdminController::updateProduct');
Router::post('/admin/products/order', 'Brew\Products\AdminController::updateProductOrder');
Router::post('/admin/products/delete', 'Brew\Products\AdminController::deleteProduct');

// Admin: Product Photo Actions
Router::get('/admin/products/photo/([0-9]+)', 'Brew\Products\AdminController::displayPhoto');
Router::post('/admin/products/photos/insert', 'Brew\Products\AdminController::insertPhoto');
Router::post('/admin/products/photos/delete', 'Brew\Products\AdminController::deletePhoto');
