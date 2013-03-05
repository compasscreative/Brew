<?php

	namespace Brew\Bundle\Galleries;

	use Reinink\Query\Table;

	class Gallery extends Table
	{
		public static $db_table = 'galleries';
		public static $db_fields = array(
			array('name' => 'id'),
			array('name' => 'title'),
			array('name' => 'description'),
			array('name' => 'priority')
		);

		public $id;
		public $title;
		public $introduction;
		public $priority;
	}