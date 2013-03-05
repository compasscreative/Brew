<?php

	use Reinink\Query\DB;
	use Reinink\Utils\Config;

	/*
	|--------------------------------------------------------------------------
	| Storage path
	|--------------------------------------------------------------------------
	|
	| Path of local folder where application generated date will be stored.
	| This can also be the location of any SQLite databases.
	|
	*/

		Config::set('storage_path', BASE_PATH . 'storage/');


	/*
	|--------------------------------------------------------------------------
	| Displaying errors
	|--------------------------------------------------------------------------
	|
	| Sets whether or not descriptive errors are displayed. By default this is
	| set to false for production environments, but it can be overwritten for
	| development environments in the environment specific configuration file.
	|
	*/

		Config::set('display_errors', false);


	/*
	|--------------------------------------------------------------------------
	| Logging errors
	|--------------------------------------------------------------------------
	|
	| Sets whether or not errors should be logged. Set to false to disable
	| error logging, otherwise set the path of a local error log folder.
	|
	*/

		Config::set('error_log_path', Config::get('storage_path') . 'errors/');


	/*
	|--------------------------------------------------------------------------
	| Timezone
	|--------------------------------------------------------------------------
	|
	| As of PHP 5.4 you must set the default timezone in order to use the
	| date functions, otherwise a warning will be generated.
	|
	*/

		date_default_timezone_set('America/Toronto');


	/*
	|--------------------------------------------------------------------------
	| Database connection
	|--------------------------------------------------------------------------
	|
	| Connect to a MySQL or SQLite database. It is recommended that you add
	| this setting to your environement specific configuration file. Examples:
	|
	| DB::mysql('localhost', 'username', 'password', 'database');
	| DB::sqlite(Config::get('storage_path') . 'database.sqlite');
	|
	*/

		DB::sqlite(Config::get('storage_path') . 'database.sqlite');


	/*
	|--------------------------------------------------------------------------
	| ImageMagick
	|--------------------------------------------------------------------------
	|
	| ImageMagick is a popular image editing tool, and is used by many of
	| the Brew bundles. This setting defines the local path of the primary
	| ImageMagick utility, convert.
	|
	*/

		Config::set('imagemagick', 'convert');