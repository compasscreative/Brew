<?php

namespace Brew\Bundle\Leads;

use Reinink\Query\Table;

class Lead extends Table
{
	public static $db_table = 'leads';
	public static $db_fields = array(
		array('name' => 'id'),
		array('name' => 'date'),
		array('name' => 'ip_address'),
		array('name' => 'name'),
		array('name' => 'email'),
		array('name' => 'phone'),
		array('name' => 'address'),
		array('name' => 'interest'),
		array('name' => 'budget'),
		array('name' => 'message'),
		array('name' => 'referral'),
		array('name' => 'url')
	);

	public $id;
	public $date;
	public $ip_address;
	public $name;
	public $email;
	public $phone;
	public $address;
	public $interest;
	public $budget;
	public $message;
	public $referral;
	public $url;
}