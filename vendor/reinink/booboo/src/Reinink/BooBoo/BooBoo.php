<?php
/**
 * A PHP class that manages uncaught exceptions and errors.
 *
 * @package  BooBoo
 * @version  1.0
 * @author   Jonathan Reinink <jonathan@reininks.com>
 * @link     https://github.com/reinink/BooBoo
 */

namespace Reinink\BooBoo;

use \ErrorException;

class BooBoo
{
	public static function exception($e, $trace = true)
	{
		ob_get_level() and ob_end_clean();

		echo '<html>';
		echo '<head><title>Error</title></head>';
		echo '<body>';
		echo '<h1>Error</h1>';
		echo '<p>' . $e->getMessage() . '</p>';
		echo '<p><strong>Line ' . $e->getLine() . '</strong> in ' . $e->getFile() . '</p>';

		if ($trace)
		{
			echo '<pre>' . $e->getTraceAsString() . '</pre>';
		}

		echo '</body>';
		echo '</html>';
		exit;
	}

	public static function native($code, $error, $file, $line)
	{
		static::exception(new ErrorException($error, $code, 0, $file, $line));
	}

	public static function shutdown()
	{
		if ($error = error_get_last())
		{
			extract($error, EXTR_SKIP);

			static::exception(new ErrorException($message, $type, 0, $file, $line), false);
		}
	}
}