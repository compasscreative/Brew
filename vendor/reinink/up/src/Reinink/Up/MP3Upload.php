<?php
/**
 * A class that makes MP3 uploading a little easier.
 *
 * @package  Up
 * @version  1.0
 * @author   Jonathan Reinink <jonathan@reininks.com>
 * @link     https://github.com/reinink/Up
 */

namespace Reinink\Up;

class MP3Upload extends FileUpload
{
	/**
	 * Create a new MP3Upload instance.
	 *
	 * @param	string	$file_types
	 * @return	void
	 */
	public function __construct($file_types = array('audio/mpeg'))
	{
		$this->file_types = $file_types;
	}
}