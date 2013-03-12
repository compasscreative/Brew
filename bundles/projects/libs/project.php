<?php namespace Brew\Bundle\Projects;

use Reinink\Query\Table;

class Project extends Table
{
	const DB_TABLE = 'projects';
	protected $id;
	protected $title;
	protected $introduction;
	protected $description;
	protected $awards;
	protected $show_lo_award;
	protected $completed_date;
}