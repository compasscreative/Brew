<?php

namespace Reinink\Utils;

class Str
{
	public static function slug($string)
	{
		$allowed_characters = array(

			// Spaces
			' ' => ' ',
			'-' => ' ',
			'–' => ' ',
			'—' => ' ',
			'.' => ' ',
			',' => ' ',
			'…' => ' ',
			'/' => ' ',
			'\\' => ' ',
			':' => ' ',
			';' => ' ',

			// Custom
			'%' => ' percent ',
			'&' => ' and ',
			'+' => ' plus ',
			'=' => ' equals ',
			'#' => ' number ',
		);

		// Convert string to an array
		preg_match_all('/./u', $string, $characters);

		// Create url variable
		$url = '';

		// Generate url from allowed characters
		foreach ($characters[0] as $character)
		{
			// Add if it's a number or letter
			if (ctype_alnum($character))
			{
				$url .= $character;
			}

			// Add allowed special characters
			if (isset($allowed_characters[$character]))
			{
				$url .= $allowed_characters[$character];
			}
		}

		// Remove all double spaces
		$url = preg_replace('/\s+/', ' ', $url);

		// Trim any spaces
		$url = trim($url);

		// Convert all letters to lowercase
		$url = strtolower($url);

		// Convert remaining spaces to dashes
		$url = str_replace(' ', '-', $url);

		return $url;
	}

	public static function possessive($string)
	{
		if (substr($string, -1) === 's')
		{
			return $string . '&rsquo;';
		}
		else
		{
			return $string . '&rsquo;s';
		}
	}

	public static function truncate($string, $length)
	{
		$string = trim(strip_tags($string));
		$string = preg_replace('/\s+/', ' ', $string);
		$truncated = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length));

		if(strlen($string) > $length)
		{
			return $truncated . '&hellip;';
		}
		else
		{
			return $string;
		}
	}

	public static function nl2p($string)
	{
		$paragraphs = '';

		foreach (explode("\n", $string) as $line)
		{
			if (trim($line))
			{
				$paragraphs .= '<p>' . $line . '</p>';
			}
		}

		return $paragraphs;
	}
}