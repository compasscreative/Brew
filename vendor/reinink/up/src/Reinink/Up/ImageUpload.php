<?php
/**
 * A class that makes image uploading a little easier.
 *
 * @package  Up
 * @version  1.0
 * @author   Jonathan Reinink <jonathan@reininks.com>
 * @link     https://github.com/reinink/Up
 */

namespace Reinink\Up;

use Reinink\Magick\Magick;

class ImageUpload extends FileUpload
{
	/**
	 * The Magick object.
	 *
	 * @var object
	 */
	private $im;

	/**
	 * Create a new ImageUpload instance.
	 *
	 * @param	object	$im
	 * @return	void
	 */
	public function __construct(Magick $im)
	{
		$this->im = $im;
	}

	/**
	 * Validate the uploaded file.
	 *
	 * @param	string	$upload_name
	 * @return	bool
	 */
	public function validate($upload_name)
	{
		// Parent validation
		if (!parent::validate($upload_name))
		{
			return false;
		}

		// Update Magick object with file path
		$this->im->set_file_path($this->file_path);

		// Validate that this is an image by converting it to a jpg
		if ($this->im->convert($this->file_path . '.jpg'))
		{
			// Delete the original uploaded file
			@unlink($this->file_path);

			// Update object with new file
			$this->file_path = $this->file_path . '.jpg';

			return true;
		}
		else
		{
			$this->error = 'Not a valid image file.';
			return false;
		}
	}

	/**
	 * Get uploaded image width.
	 *
	 * @return	int
	 */
	public function width()
	{
		$size = getimagesize($this->file_path);
		return $size[0];
	}

	/**
	 * Get uploaded image height.
	 *
	 * @return	int
	 */
	public function height()
	{
		$size = getimagesize($this->file_path);
		return $size[1];
	}
}