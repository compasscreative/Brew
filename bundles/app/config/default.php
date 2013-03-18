<?php
namespace Brew\App;

use Reinink\Deets\Config;

/*
|--------------------------------------------------------------------------
| Errors handling
|--------------------------------------------------------------------------
|
| Sets whether or not descriptive errors are displayed. By default this is
| set to false for production environments, but it can be overwritten for
| development environments.
|
*/

Config::set('display_errors', false);

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
| ImageMagick
|--------------------------------------------------------------------------
|
| ImageMagick is a popular image editing tool, and is used by many of
| the Brew bundles. This setting defines the local path of the primary
| ImageMagick utility, convert.
|
*/

Config::set('imagemagick', 'convert');
