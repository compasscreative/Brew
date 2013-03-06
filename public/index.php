<?php

	use Reinink\BooBoo\BooBoo;
	use Reinink\Query\DB;
	use Reinink\Reveal\Response;
	use Reinink\Reveal\View;
	use Reinink\Routy\Router;
	use Reinink\Utils\Config;


	/*
	|--------------------------------------------------------------------------
	| Path definitions
	|--------------------------------------------------------------------------
	*/
		// Set base bath
		define('BASE_PATH', dirname(dirname(__FILE__)) . '/');

		// Set public path
		define('PUBLIC_PATH', dirname(__FILE__) . '/');

		// Set storage path
		define('STORAGE_PATH', dirname(dirname(__FILE__)) . '/storage/');


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
	| Database connection
	|--------------------------------------------------------------------------
	*/

		// Connect to SQLite database
		DB::sqlite(STORAGE_PATH . 'database.sqlite');

		// Get list of existing tables
		Config::set('db_tables', explode(',', DB::value('SELECT group_concat(name) FROM sqlite_master WHERE type = "table"')));


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

		// Load bundle config files
		foreach ($bundles as $bundle)
		{
			$folder = BASE_PATH . 'bundles/' . $bundle . '/config/';

			foreach (array('setup', 'default', 'production', 'development', 'routes') as $file)
			{
				if (is_file($folder . $file . '.php'))
				{
					include $folder . $file . '.php';
				}
			}
		}


	/*
	|--------------------------------------------------------------------------
	| Run app
	|--------------------------------------------------------------------------
	*/

		if ($response = Router::run())
		{
			Response::handle($response);
		}
		else
		{
			Response::error_404(View::make('404')->render())->output();
		}
