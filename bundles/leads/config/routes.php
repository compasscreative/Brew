<?php
namespace Brew\Leads;

use Reinink\Routy\Router;

// Public
Router::post('/leads/submit', 'Brew\Leads\PublicController::process');

// Admin
Router::get('/admin/leads', 'Brew\Leads\AdminController::index');
Router::get('/admin/leads/edit/([0-9]+)', 'Brew\Leads\AdminController::edit');
Router::post('/admin/leads/delete', 'Brew\Leads\AdminController::delete');
