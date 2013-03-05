<?php

	namespace Brew\Bundle\Projects;

	use Reinink\Query\Table;

	class Project extends Table
	{
		public static $db_table = 'projects';
		public static $db_fields = array(
			array('name' => 'id'),
			array('name' => 'title'),
			array('name' => 'introduction'),
			array('name' => 'description'),
			array('name' => 'awards'),
			array('name' => 'show_lo_award'),
			array('name' => 'date_completed')
		);

		public $id;
		public $title;
		public $introduction;
		public $description;
		public $awards;
		public $show_lo_award;
		public $date_completed;
	}