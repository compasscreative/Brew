<?php
namespace Brew\Team;

use Reinink\Trailmix\Config;
use Reinink\Routy\Router;

// Public
Router::get(Config::get('team::base_url'), 'Brew\Team\PublicController::displayIndex');
Router::get(Config::get('team::base_url') . '/([0-9]+)/([a-z-0-9]+)', 'Brew\Team\PublicController::displayTeamMember');
Router::get(Config::get('team::base_url') . '/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)/[0-9]+', 'Brew\Team\PublicController::displayPhoto');

// Admin: Pages
Router::get('/admin/team', 'Brew\Team\AdminController::displayTeamMembers');
Router::get('/admin/team/add', 'Brew\Team\AdminController::addTeamMember');
Router::get('/admin/team/edit/([0-9]+)', 'Brew\Team\AdminController::editTeamMember');

// Admin: Actions
Router::post('/admin/team/insert', 'Brew\Team\AdminController::insertTeamMember');
Router::post('/admin/team/update', 'Brew\Team\AdminController::updateTeamMember');
Router::post('/admin/team/order', 'Brew\Team\AdminController::updateTeamMemberOrder');
Router::post('/admin/team/delete', 'Brew\Team\AdminController::deleteTeamMember');
Router::post('/admin/team/insert-photo', 'Brew\Team\AdminController::insertPhoto');
