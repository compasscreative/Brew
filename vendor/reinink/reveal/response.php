<?php

namespace Reinink\Reveal;

class Response
{
	public $content;
	public $status;
	public $headers;

	public function __construct($content, $status = 200, $headers = array())
	{
		$this->content = $content;
		$this->status = $status;
		$this->headers = $headers;
	}

	public function output()
	{
		if ($this->status === 404)
		{
			header('HTTP/1.0 404 Not Found');
		}

		// Add headers
		foreach ($this->headers as $name => $value)
		{
			header($name . ': ' . $value);
		}

		// Display content
		echo $this->content;
	}

	public static function handle($response)
	{
		// Response object
		if (is_object($response) and get_class($response) === 'Reinink\Reveal\Response')
		{
			$response->output();
		}
		// View object
		else if (is_object($response) and get_class($response) === 'Reinink\Reveal\View')
		{
			self::view($response)->output();
		}
		// String
		else if (is_string($response))
		{
			self::string($response)->output();
		}
		// Boolean
		else if ($response === true)
		{
			self::string('')->output();
		}
		else
		{
			self::error_404('Page not found.')->output();
		}
	}

	public static function view(View $view, $status = 200, $headers = array())
	{
		return new static($view->render(), $status, $headers);
	}

	public static function string($string, $status = 200, $headers = array())
	{
		return new static($string, $status, $headers);
	}

	public static function json($data, $status = 200, $headers = array())
	{
		$headers['Content-Type'] = 'application/json; charset=utf-8';

		return new static(json_encode($data), $status, $headers);
	}

	public static function pdf($path, $filename = 'document.pdf')
	{
		$headers['Content-Type'] = 'application/pdf';
		$headers['Content-Disposition'] = 'inline; filename=' . $filename;

		return new static(file_get_contents($path), 200, $headers);
	}

	public static function jpg($path, $filename = 'image.jpg')
	{
		$headers['Content-Type'] = 'image/jpeg';
		$headers['Content-Disposition'] = 'inline; filename=' . $filename;

		return new static(file_get_contents($path), 200, $headers);
	}

	public static function error_404($message = '')
	{
		return new static($message, 404, $headers = array());
	}
}