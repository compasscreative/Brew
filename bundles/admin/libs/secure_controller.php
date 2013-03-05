<?php

namespace Brew\Bundle\Admin;

abstract class Secure_Controller
{
	public function __construct()
	{
		// Start the session
		session_name('admin::session_id');
		session_cache_limiter('private_no_expire, must-revalidate');
		session_start();

		// Make sure user is logged in
		if (!isset($_SESSION['admin::logged_in']) or !$_SESSION['admin::logged_in'])
		{
			header('Location: /admin/login');
			exit;
		}
	}
}