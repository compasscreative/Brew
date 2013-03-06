<?php

namespace Brew\Bundle\Leads;

use Reinink\Query\Table;

class Lead extends Table
{
	protected static $db_table = 'leads';
	protected $id;
	protected $submitted_date;
	protected $ip_address;
	protected $name;
	protected $email;
	protected $phone;
	protected $address;
	protected $interest;
	protected $budget;
	protected $message;
	protected $referral;
	protected $url;
}