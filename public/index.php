<?php

	use Reinink\BooBoo\BooBoo;
	use Reinink\Reveal\Response;
	use Reinink\Reveal\View;
	use Reinink\Routy\Router;


	/*
	|--------------------------------------------------------------------------
	| Path definitions
	|--------------------------------------------------------------------------
	*/

		// Set public path
		define('PUBLIC_PATH', dirname(__FILE__) . '/');

		// Set base application bath
		define('BASE_PATH', dirname(dirname(__FILE__)) . '/');


	/*
	|--------------------------------------------------------------------------
	| Setup error handling
	|--------------------------------------------------------------------------
	*/

		set_exception_handler(function($e)
		{
			BooBoo::exception($e);
		});

		set_error_handler(function($code, $error, $file, $line)
		{
			BooBoo::native($code, $error, $file, $line);
		});

		register_shutdown_function(function()
		{
			BooBoo::shutdown();
		});

		error_reporting(-1);


	/*
	|--------------------------------------------------------------------------
	| Setup auto loading
	|--------------------------------------------------------------------------
	*/

		// Bundle classes
		spl_autoload_register(function($class)
		{
			if (strpos($class, 'Brew\Bundle') === 0)
			{
				$parts = explode('\\', $class);
				return include BASE_PATH . 'bundles/' . strtolower($parts[2]) . '/libs/' . strtolower($parts[3] . '.php');
			}
		});

		// Vendor classes
		include BASE_PATH . 'vendor/autoload.php';


	/*
	|--------------------------------------------------------------------------
	| Setup bundle path shortcuts
	|--------------------------------------------------------------------------
	*/
		View::$path_override = function($path)
		{
			// Set default bundle
			if (strpos($path, '::') === false)
			{
				$path = 'app::' . $path;
			}

			// Break path into parts
			$parts = explode('::', $path);

			// Set file path
			return BASE_PATH . 'bundles/' . implode('/', array_slice($parts, 0, -1)) . '/views/' . end($parts) . '.php';
		};


	/*
	|--------------------------------------------------------------------------
	| Load bundles
	|--------------------------------------------------------------------------
	*/
		// Array to house bundles
		$bundles = array('app');

		// Get list of bundles
		foreach (new DirectoryIterator(BASE_PATH . 'bundles') as $file)
		{
			if ($file->isDir() and !$file->isDot() and $file->getBasename() !== 'app')
			{
				$bundles[] = $file->getBasename();
			}
		}

		// Load each bundle
		foreach ($bundles as $bundle)
		{
			$folder = BASE_PATH . 'bundles/' . $bundle . '/';

			if (is_file($folder . 'config/default.php'))
			{
				include $folder . 'config/default.php';
			}

			if (getenv('APPLICATION_ENV') and is_file($folder . 'config/' . getenv('APPLICATION_ENV') . '.php'))
			{
				include $folder . 'config/' . getenv('APPLICATION_ENV') . '.php';
			}

			if (is_file($folder . 'routes.php'))
			{
				include $folder . 'routes.php';
			}
		}


	/*
	|--------------------------------------------------------------------------
	| Run app
	|--------------------------------------------------------------------------
	*/

		Response::handle(Router::run());