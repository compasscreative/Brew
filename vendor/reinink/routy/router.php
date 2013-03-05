<?php

namespace Reinink\Routy;

use \ReflectionFunction;
use \ReflectionClass;

class Router
{
	public static $routes;

	public static function get($uri, $callback)
	{
		self::$routes[] = array(
			'type' => array('GET', 'HEAD'),
			'uri' => $uri,
			'callback' => $callback
		);
	}

	public static function post($uri, $callback)
	{
		self::$routes[] = array(
			'type' => array('POST'),
			'uri' => $uri,
			'callback' => $callback
		);
	}

	public static function import($routes)
	{
		foreach ($routes as $route)
		{
			self::$routes[] = array(
				'type' => ($route[0] === 'GET') ? array('GET', 'HEAD') : array($route[0]),
				'uri' => $route[1],
				'callback' => $route[2]
			);
		}
	}

	public static function run()
	{
		// Set correct url
		$correct_url = Request::uri() !== '/' ? Request::domain() . rtrim(Request::uri(), '/') : Request::domain() . Request::uri();

		// Redirect if requested url does not match correct url
		if (Request::domain() . Request::uri() !== $correct_url)
		{
			header('Location: //' . $correct_url, true, 301);
			exit;
		}

		// Find and call matching route
		foreach (self::$routes as $route)
		{
			if (in_array(Request::method(), $route['type']) and preg_match('#^' . $route['uri'] . '$#', Request::uri(), $matches))
			{
				// Remove first match
				unset($matches[0]);

				if (is_object($route['callback']) or function_exists($route['callback']))
				{
					// Create new reflection function
					$function = new ReflectionFunction($route['callback']);

					// Class function
					return call_user_func_array($route['callback'], $matches);
				}
				else
				{
					// Get class and method
					list($class, $method) = explode('::', $route['callback']);

					// Create reflection class
					$reflection = new ReflectionClass($class);

					// Instantiate class with any supplied arguments
					$class = $reflection->newInstanceArgs(func_get_args());

					// Class method
					return call_user_func_array(array($class, $method), $matches);
				}
			}
		}

		return false;
	}
}