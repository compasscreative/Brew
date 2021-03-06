<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Reveal\ResponseException;
use Reinink\Reveal\ViewResponse;
use Reinink\Routy\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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

// Check if storage exists and is writeable
if (!is_writable(STORAGE_PATH)) {
    die('Storage folder is not writeable.');
}


/*
|--------------------------------------------------------------------------
| Setup auto loading
|--------------------------------------------------------------------------
*/

// Vendor classes
include BASE_PATH . 'vendor/autoload.php';

// Bundle classes
spl_autoload_register(
    function ($class) {
        if (strpos($class, 'Brew') === 0) {
            $parts = explode('\\', $class);
            return include BASE_PATH . 'bundles/' . strtolower($parts[1]) . '/libraries/' . $parts[2] . '.php';
        }
    }
);

// Aliases
spl_autoload_register(
    function ($class) {

        $aliases = [
            'Asset' => 'Reinink\Trailmix\Asset',
            'Config' => 'Reinink\Trailmix\Config',
            'Request' => 'Reinink\Routy\Request',
            'URI' => 'Reinink\Routy\URI'
        ];

        if (isset($aliases[$class])) {
            return class_alias($aliases[$class], $class);
        }
    }
);


/*
|--------------------------------------------------------------------------
| Setup error handling
|--------------------------------------------------------------------------
*/

$whoops = new Run;
$whoops->pushHandler(
    function ($exception, $inspector, $whoops) {

        // Remove any previous output
        ob_get_level() and ob_end_clean();

        // Set response code
        http_response_code(500);

        // Create logs folder
        if (!is_dir(STORAGE_PATH . 'logs/')) {
            mkdir(STORAGE_PATH . 'logs/');
        }

        // Log error
        $logger = new Logger('errors');
        $logger->pushHandler(new StreamHandler(STORAGE_PATH . 'logs/errors.log'));
        $logger->critical(
            $exception->getMessage(),
            array(
                'Message' => $exception->getMessage(),
                'File' => $exception->getFile(),
                'Line' => $exception->getLine()
            )
        );

        // Display errors
        if (Config::get('display_errors')) {
            if (Request::ajax()) {
                echo "Message:\n" . $exception->getMessage() . "\n\n";
                echo "File:\n" . $exception->getFile() . "\n\n";
                echo "Line:\n" . $exception->getLine();
            } else {
                $whoops->pushHandler(new PrettyPageHandler());
                $whoops->handleException($exception);
            }
        }

        exit;
    }
);
$whoops->register();


/*
|--------------------------------------------------------------------------
| Database connection
|--------------------------------------------------------------------------
*/

// Connect to SQLite database
DB::sqlite(STORAGE_PATH . 'database.sqlite');

// Get list of existing tables
Config::set('db_tables', explode(',', DB::field('SELECT group_concat(name) FROM sqlite_master WHERE type = "table"')));

/*
|--------------------------------------------------------------------------
| Setup bundle paths and shortcuts
|--------------------------------------------------------------------------
*/

// Assets
Asset::$public_path = PUBLIC_PATH;

// Views
ViewResponse::$callback = function ($path) {

    // Set default bundle
    if (strpos($path, '::') === false) {
        $path = 'app::' . $path;
    }

    // Break path into parts
    $parts = explode('::', $path);

    // Set file path
    return BASE_PATH . 'bundles/' . implode('/', array_slice($parts, 0, -1)) . '/views/' . end($parts) . '.tpl';
};

// SQL
DB::$callback = function ($sql) {

    // Was an SQL file requested?
    if (strpos($sql, ' ') === false) {

        // Use SQL as path
        $path = $sql;

        // Set default bundle
        if (strpos($path, '::') === false) {
            $path = 'app::' . $path;
        }

        // Break path into parts
        $parts = explode('::', $path);

        // Return SQL from file
        return file_get_contents(BASE_PATH . 'bundles/' . implode('/', array_slice($parts, 0, -1)) . '/sql/' . end($parts) . '.sql');

    } else {

        return $sql;
    }
};

/*
|--------------------------------------------------------------------------
| Load bundles
|--------------------------------------------------------------------------
*/

// Array to house bundles
$bundles = ['app'];

// Get list of bundles
foreach (new DirectoryIterator(BASE_PATH . 'bundles') as $file) {
    if ($file->isDir() and !$file->isDot() and $file->getBasename() !== 'app') {
        $bundles[] = $file->getBasename();
    }
}

// Load bundle config files
foreach ($bundles as $bundle) {

    $folder = BASE_PATH . 'bundles/' . $bundle . '/config/';

    foreach (array('setup', 'options', 'local', 'routes') as $file) {
        if (is_file($folder . $file . '.php')) {
            include $folder . $file . '.php';
        }
    }
}

/*
|--------------------------------------------------------------------------
| Run app
|--------------------------------------------------------------------------
*/

try {

    Response::get(Router::run())->send();

} catch (ResponseException $e) {

    if (Config::get('display_errors')) {
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->handleException($e);
    } else {
        $view = new ViewResponse('error', $e->getCode());
        $view->exception = $e;
        $view->send();
    }
}
