<?php

namespace Reinink\Reveal;

class ErrorResponse extends Response
{
	/**
	 * The error message.
	 *
	 * @var string
	 */
	public $message;

	/**
	 * Create a new Error instance.
	 *
	 * @param	string	$content
	 * @param	array	$headers
	 * @return	void
	 */
	public function __construct($message, $code)
	{
		$this->content = null;
		$this->code = $code;
		$this->headers = array();
		$this->message = $message;
	}

	/**
	 * Send the headers and content of the response to the browser.
	 *
	 * @return	void
	 */
	public function send()
	{
		if (!$this->content)
		{
			$this->content = '<!DOCTYPE html>';
			$this->content .= '<html lang="en">';
			$this->content .= '<head>';
			$this->content .= '<meta charset="utf-8">';
			$this->content .= '<title>Error ' . $this->code . '</title>';
			$this->content .= '</head>';
			$this->content .= '<body>';
			$this->content .= '<h1>Error ' . $this->code . '</h1>';
			$this->content .= '<p>' . $this->message . '</p>';
			$this->content .= '</body>';
			$this->content .= '</html>';
		}

		switch ($this->code)
		{
			case 400: $this->headers[] = array('HTTP/1.1 400 Bad Request', 400); break;
			case 401: $this->headers[] = array('HTTP/1.1 401 Unauthorized', 401); break;
			case 403: $this->headers[] = array('HTTP/1.1 403 Forbidden', 403); break;
			case 404: $this->headers[] = array('HTTP/1.1 404 Not Found', 404); break;
			case 500: $this->headers[] = array('HTTP/1.1 500 Internal Server Error', 500); break;
		}

		parent::send();
	}
}