<?php

namespace Reinink\Utils;

class Config
{
	public static $values = array();

	public static function set($key, $value)
	{
		self::$values[$key] = $value;
	}

	public static function get($key)
	{
		if (isset(self::$values[$key]))
		{
			return self::$values[$key];
		}
		else
		{
			return null;
		}
	}
}