<?php

namespace Reinink\Routy;

class URI
{
	public static function is($uri, $output = null)
	{
		return preg_match('#^' . $uri . '$#', Request::uri());
	}
}