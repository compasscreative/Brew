<?php namespace Brew\Bundle\Leads;

class Form
{
	public $from_name;
	public $from_email;
	public $recipients;
	public $name_enabled;
	public $name_required;
	public $email_enabled;
	public $email_required;
	public $phone_enabled;
	public $phone_required;
	public $address_enabled;
	public $address_required;
	public $interest_enabled;
	public $interest_required;
	public $interest_values;
	public $budget_enabled;
	public $budget_required;
	public $budget_values;
	public $message_enabled;
	public $message_required;
	public $referral_enabled;
	public $referral_required;

	public function __construct($from_name, $from_email, $recipients)
	{
		$this->from_name = $from_name;
		$this->from_email = $from_email;
		$this->recipients = $recipients;
	}

	public function enable_name($required = false)
	{
		$this->name_enabled = true;
		$this->name_required = $required;
	}

	public function enable_email($required = false)
	{
		$this->email_enabled = true;
		$this->email_required = $required;
	}

	public function enable_phone($required = false)
	{
		$this->phone_enabled = true;
		$this->phone_required = $required;
		return $this;
	}

	public function enable_address($required = false)
	{
		$this->address_enabled = true;
		$this->address_required = $required;
		return $this;
	}

	public function enable_interest($required = false, $values = null)
	{
		$this->interest_enabled = true;
		$this->interest_required = $required;
		$this->interest_values = $values;
		return $this;
	}

	public function enable_budget($required = false, $values = null)
	{
		$this->budget_enabled = true;
		$this->budget_required = $required;
		$this->budget_values = $values;
		return $this;
	}

	public function enable_message($required = false)
	{
		$this->message_enabled = true;
		$this->message_required = $required;
		return $this;
	}

	public function enable_referral($required = false)
	{
		$this->referral_enabled = true;
		$this->referral_required = $required;
		return $this;
	}

	public function render($id)
	{
		include BASE_PATH . 'bundles/leads/views/form.php';
	}
}