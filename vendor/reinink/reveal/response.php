<?php
/**
 * PHP libraries that make HTTP responses more manageable.
 *
 * @package  Reveal
 * @version  1.0
 * @author   Jonathan Reinink <jonathan@reininks.com>
 * @link     https://github.com/reinink/Reveal
 */

namespace Reinink\Reveal;

class Response
{
	/**
	 * The content to be sent.
	 *
	 * @var string
	 */
	public $content;

	/**
	 * The HTTP code.
	 *
	 * @var string
	 */
	public $code;

	/**
	 * An array of HTTP headers.
	 *
	 * @var int
	 */
	public $headers;

	/**
	 * Create a new Response instance.
	 *
	 * @param	string	$content
	 * @param	array	$headers
	 * @return	void
	 */
	public function __construct($content = null, $code = 200, $headers = array())
	{
		$this->content = $content;
		$this->code = $code;
		$this->headers = $headers;
	}

	/**
	 * Send the headers and content of the response to the browser.
	 *
	 * @return	void
	 */
	public function send()
	{
		foreach ($this->headers as $header)
		{
			if (isset($header[1]))
			{
				header($header[0], true, $header[1]);
			}
			else
			{
				header($header[0]);
			}
		}

		if (!is_null($this->content))
		{
			echo $this->content;
		}
	}

	/**
	 * Create a ViewResponse using an array of values.
	 *
	 * @param	string	$path
	 * @param	array	$values
	 * @return	ViewResponse
	 */
	public static function view($path, $values = array())
	{
		$view = new ViewResponse($path);

		foreach ($values as $name => $value)
		{
			$view->$name = $value;
		}

		return $view;
	}

	/**
	 * Create a JSONResponse from an array.
	 *
	 * @param	array	$data
	 * @return	JSONResponse
	 */
	public static function json($data)
	{
		return new JSONResponse($data);
	}

	/**
	 * Create a FileResponse for a PDF file.
	 *
	 * @param	string	$path
	 * @param	string	$filename
	 * @param	bool	$download
	 * @return	FileResponse
	 */
	public static function pdf($path, $filename = null, $download = false)
	{
		if (!is_file($path))
		{
			return new ErrorResponse('PDF Not Found.', 404);
		}

		return new FileResponse($path, 'application/pdf', $filename, $download);
	}

	/**
	 * Create a FileResponse for a JPG file.
	 *
	 * @param	string	$path
	 * @param	string	$filename
	 * @param	bool	$download
	 * @return	FileResponse
	 */
	public static function jpg($path, $filename = null, $download = false)
	{
		if (!is_file($path))
		{
			return new ErrorResponse('Image Not Found.', 404);
		}

		return new FileResponse($path, 'image/jpeg', $filename, $download);
	}

	/**
	 * Create a FileResponse for a PNG file.
	 *
	 * @param	string	$path
	 * @param	string	$filename
	 * @param	bool	$download
	 * @return	FileResponse
	 */
	public static function png($path, $filename = null, $download = false)
	{
		if (!is_file($path))
		{
			return new ErrorResponse('Image Not Found.', 404);
		}

		return new FileResponse($path, 'image/png', $filename, $download);
	}

	/**
	 * Create a RedirectResponse for a redirect.
	 *
	 * @param	string	$url
	 * @return	RedirectResponse
	 */
	public static function redirect($url, $code = 301)
	{
		return new RedirectResponse($url, $code);
	}

	/**
	 * Create a ErrorResponse for a bad request.
	 *
	 * @param	string	$content
	 * @return	ErrorResponse
	 */
	public static function bad_request($message = 'Bad Request.')
	{
		return new ErrorResponse($message, 400);
	}

	/**
	 * Create a ErrorResponse for a unauthorized request.
	 *
	 * @param	string	$message
	 * @return	ErrorResponse
	 */
	public static function unauthorized($message = 'Unauthorized.')
	{
		return new ErrorResponse($message, 401);
	}

	/**
	 * Create a ErrorResponse for a unauthorized request.
	 *
	 * @param	string	$message
	 * @return	ErrorResponse
	 */
	public static function forbidden($message = 'Forbidden.')
	{
		return new ErrorResponse($message, 403);
	}

	/**
	 * Create a ErrorResponse for a page not found.
	 *
	 * @param	string	$message
	 * @return	ErrorResponse
	 */
	public static function not_found($message = 'Page Not Found.')
	{
		return new ErrorResponse($message, 404);
	}

	/**
	 * Create a ErrorResponse for a server error.
	 *
	 * @param	string	$message
	 * @return	ErrorResponse
	 */
	public static function server_error($message = 'Internal Server Error.')
	{
		return new ErrorResponse($message, 500);
	}

	/**
	 * Get valid Response object from various responses.
	 *
	 * @param	mixed	$response
	 * @param	object	$error
	 * @return	void
	 */
	public static function get($response)
	{
		if (is_object($response) and $response instanceof Response)
		{
			return $response;
		}
		else if (is_string($response))
		{
			return new Response($response);
		}
		else if (is_bool($response) and $response === true)
		{
			return new Response();
		}
		else
		{
			return self::not_found();
		}
	}
}