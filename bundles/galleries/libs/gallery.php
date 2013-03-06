<?php

	namespace Brew\Bundle\Galleries;

	use Reinink\Query\Table;

	class Gallery extends Table
	{
		protected static $db_table = 'galleries';
		protected $id;
		protected $title;
		protected $description;
		protected $priority;
	}