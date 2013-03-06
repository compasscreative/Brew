<?php

	namespace Brew\Bundle\Projects;

	use Reinink\Query\Table;

	class Project extends Table
	{
		protected static $db_table = 'projects';
		protected $id;
		protected $title;
		protected $introduction;
		protected $description;
		protected $awards;
		protected $show_lo_award;
		protected $completed_date;
	}