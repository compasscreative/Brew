<?php
namespace Brew\Admin;

use Brew\App\Brew;
use Reinink\Trailmix\Config;
use Reinink\Reveal\Response;

class PublicController
{
    public function __construct()
    {
        // Start the session
        session_name('admin::session_id');
        session_cache_limiter('private_no_expire, must-revalidate');
        session_start();
    }

    public function index()
    {
        return Response::redirect(Config::get('admin::default_page'));
    }

    public function loginForm()
    {
        return Response::view('admin::login');
    }

    public function processLogin()
    {
        // Check for required paramaters
        if (!isset($_POST['username']) or
            !isset($_POST['password'])) {
            return false;
        }

        // Validate username and password
        foreach (Config::$values['admin::users'] as $user) {
            if ($user['username'] === $_POST['username'] and $user['password'] === $_POST['password']) {

                $_SESSION['admin::logged_in'] = true;

                return Response::redirect(Config::get('admin::default_page'));
            }
        }

        return Response::view('admin::login');
    }

    public function processLogout()
    {
        // End session
        $_SESSION['admin::logged_in'] = false;

        // Redirect to login
        return Response::redirect('/admin/login');
    }
}
