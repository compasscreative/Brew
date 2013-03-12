<?php

namespace Reinink\Reveal;

class FileResponse extends Response
{
	/**
	 * The file path.
	 *
	 * @var string
	 */
	public $path;

	/**
	 * The file mime type.
	 *
	 * @var string
	 */
	public $mime;

	/**
	 * The file name.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The file download status.
	 *
	 * @var bool
	 */
	public $download;


	/**
	 * Create a new File instance.
	 *
	 * @param	string	$content
	 * @param	array	$headers
	 * @return	void
	 */
	public function __construct($path, $mime = null, $name = null, $download = false)
	{
		$this->content = null;
		$this->code = 200;
		$this->headers = array();
		$this->path = $path;
		$this->mime = $mime;
		$this->name = $name;
		$this->download = $download;
	}

	public function send()
	{
		$headers[0][0] = 'Content-Type: ' . $this->mime;
		$headers[1][0] = $this->download ? 'Content-Disposition: attachment;' : 'Content-Disposition: inline;';
		$headers[1][0] .= $this->name ? ' filename=' . $this->name : '';

		$this->headers = array_merge($headers, $this->headers);

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

		readfile($this->path);
		exit;
	}
}