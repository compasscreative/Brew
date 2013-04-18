<?php

namespace Brew\Admin;

use Reinink\Routy\Router;

Router::get('/admin', 'Brew\Admin\PublicController::index');
Router::get('/admin/login', 'Brew\Admin\PublicController::loginForm');
Router::post('/admin/login', 'Brew\Admin\PublicController::processLogin');
Router::get('/admin/logout', 'Brew\Admin\PublicController::processLogout');
