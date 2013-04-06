<?php

namespace Brew\Leads;

use Reinink\Query\Table;

class Lead extends Table
{
    const DB_TABLE = 'leads';
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
