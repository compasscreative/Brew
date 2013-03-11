<?php

namespace Reinink\Reveal;

class JSONResponse extends Response
{
	/**
	 * The data array.
	 *
	 * @var array
	 */
	public $data;

	/**
	 * Create a new JSON instance.
	 *
	 * @param	string	$content
	 * @param	array	$headers
	 * @return	void
	 */
	public function __construct($data)
	{
		$this->content = null;
		$this->code = 200;
		$this->headers = array
		(
			array('Content-Type: text/plain')
		);
		$this->data = $data;
	}

	/**
	 * Send the headers and content of the response to the browser.
	 *
	 * @return	void
	 */
	public function send()
	{
		$this->content = json_encode($this->data);

		parent::send();
	}
}