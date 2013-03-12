<?php
/**
 * An HTML5 Boilerplate inspired cache buster for CSS and JavaScript files.
 *
 * @package  Buster
 * @version  1.0
 * @author   Jonathan Reinink <jonathan@reininks.com>
 * @link     https://github.com/reinink/Buster
 */

namespace Reinink\Buster;

class Buster
{

	/**
	 * The public folder path.
	 *
	 * @var string
	 */
	private $public_path;

	/**
	 * Create a new Buster instance.
	 *
	 * @param	string	$public_path
	 * @return	void
	 */
	public function __construct($public_path)
	{
		$this->public_path = $public_path;
	}

	/**
	 * Create a CSS <link> tag with a cached url.
	 *
	 * @param	string	$url
	 * @return	string
	 */
	public function css($url)
	{
		return '<link rel="stylesheet" href="' . self::url($this->public_path, $url) . '" />';
	}

	/**
	 * Create a JavaScript <script> tag with a cached url.
	 *
	 * @param	string	$url
	 * @return	string
	 */
	public function js($url)
	{
		return '<script src="' . self::url($this->public_path, $url) . '"></script>';
	}

	/**
	 * Generate a timestamped cached url.
	 *
	 * @param	string	$public_path
	 * @param	string	$url
	 * @return	string
	 */
	public static function url($public_path, $url)
	{
		if (file_exists($public_path . $url) and $last_updated = filemtime($public_path . $url))
		{
			$path = pathinfo($url);
			return $path['dirname'] . '/' . $path['filename'] . '.' . $last_updated . '.' . $path['extension'];
		}
		else
		{
			return false;
		}
	}
}