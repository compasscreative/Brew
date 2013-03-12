<?php namespace Brew\Bundle\Admin;

use Brew\Bundle\App\Brew;
use Reinink\Deets\Config;
use Reinink\Reveal\Response;

class Public_Controller
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
		header('Location: ' . Config::get('admin::default_page'), true, 301);
		exit;
	}

	public function login_form()
	{
		return Response::view('admin::login');
	}

	public function process_login()
	{
		// Check for required paramaters
		if (!isset($_POST['username']) or
			!isset($_POST['password']))
		{
			return false;
		}

		// Validate username and password
		foreach (Config::$values['admin::users'] as $user)
		{
			if ($user['username'] === $_POST['username'] and
				$user['password'] === $_POST['password'])
			{
				$_SESSION['admin::logged_in'] = true;

				header('Location: ' . Config::get('admin::default_page'), true, 301);
				exit;
			}
		}

		return Response::view('admin::login');
	}

	public function process_logout()
	{
		// End session
		$_SESSION['admin::logged_in'] = false;

		// Redirect to login
		header('Location: /admin/login');
		exit;
	}
}