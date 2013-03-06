<?php

namespace Reinink\Reveal;

use \Exception;

class View
{
	public static $callback;
	private $view;

	public function __construct($path)
	{
		if (is_callable(self::$callback))
		{
			$path = call_user_func_array(self::$callback, array($path));
		}

		if (!is_file($path))
		{
			throw new Exception('View not found: ' . $path);
		}

		$this->view = $path;
	}

	private function insert($path)
	{
		if (is_callable(self::$callback))
		{
			$path = call_user_func_array(self::$callback, array($path));
		}

		if (!is_file($path))
		{
			throw new Exception('View not found: ' . $path);
		}

		include $path;
	}

	public function render()
	{
		ob_start();

		include($this->view);

		$output = ob_get_contents();

		ob_end_clean();

		return $output;
	}

	public static function make($path, $values = null)
	{
		$view = new self($path);

		if (!is_null($values))
		{
			foreach ($values as $name => $value)
			{
				$view->$name = $value;
			}
		}

		return $view;
	}
}