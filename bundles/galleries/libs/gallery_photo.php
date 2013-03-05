<?php

	namespace Brew\Bundle\Galleries;

	use Reinink\Query\Table;
	use Reinink\Utils\Config;

	class Gallery_Photo extends Table
	{
		public static $db_table = 'gallery_photos';
		public static $db_fields = array(
			array('name' => 'id'),
			array('name' => 'gallery_id'),
			array('name' => 'caption'),
			array('name' => 'display_order')
		);

		public $id;
		public $gallery_id;
		public $section;
		public $caption;
		public $display_order;

		public function delete()
		{
			// Set image folder
			$folder = Config::get('storage_path') . 'gallery_photos/' . $this->id . '/';

			// Delete all images
			if (is_file($folder . 'xlarge.jpg'))
			{
				unlink($folder . 'xlarge.jpg');
			}

			if (is_file($folder . 'large.jpg'))
			{
				unlink($folder . 'large.jpg');
			}

			if (is_file($folder . 'medium.jpg'))
			{
				unlink($folder . 'medium.jpg');
			}

			if (is_file($folder . 'small.jpg'))
			{
				unlink($folder . 'small.jpg');
			}

			if (is_file($folder . 'xsmall.jpg'))
			{
				unlink($folder . 'xsmall.jpg');
			}

			// Delete the folder
			if (is_dir($folder))
			{
				rmdir($folder);
			}

			// Delete from database
			parent::delete();
		}
	}