<?php
/**
 * A class that makes PDF uploading a little easier.
 *
 * @package  Up
 * @version  1.0
 * @author   Jonathan Reinink <jonathan@reininks.com>
 * @link     https://github.com/reinink/Up
 */

namespace Reinink\Up;

class PDFUpload extends FileUpload
{
	/**
	 * Create a new PDFUpload instance.
	 *
	 * @param	string	$file_types
	 * @return	void
	 */
	public function __construct($file_types = array('application/pdf'))
	{
		$this->file_types = $file_types;
	}
}