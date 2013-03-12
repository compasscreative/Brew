<?php

namespace Reinink\Reveal;

class RedirectResponse extends Response
{
	/**
	 * Create a new Redirect instance.
	 *
	 * @param	string	$content
	 * @param	array	$headers
	 * @return	void
	 */
	public function __construct($url, $code)
	{
		$this->content = null;
		$this->code = $code;
		$this->headers = array
		(
			array('Location: ' . $url, $code)
		);
	}

	/**
	 * Send the headers of the response to the browser.
	 *
	 * @return	void
	 */
	public function send()
	{
		parent::send();
		exit;
	}
}