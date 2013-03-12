<?php namespace Brew\Bundle\Leads;

use \Exception;

class Process_Lead
{
	private $form;
	private $params;

	public function __construct(Form $form, $params)
	{
		$this->form = $form;
		$this->params = $params;
	}

	public function process()
	{
		// Create a new lead
		$lead = new Lead();

		// Set submitted date
		$lead->submitted_date = date('Y-m-d H:i:s');

		// Set IP address
		$lead->ip_address = $_SERVER['REMOTE_ADDR'];

		// Set (referring) url
		if (isset($_SERVER['HTTP_REFERER']))
		{
			$lead->url = $_SERVER['HTTP_REFERER'];
		}

		// Validate and set name
		if ($this->form->name_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['name']))
			{
				throw new Expection('Missing paramater: name');
			}

			// Check if this field is required
			if ($this->form->name_required and trim($this->params['name']) === '')
			{
				throw new Exception('Required field: name');
			}

			$lead->name = $this->params['name'];
		}

		// Validate and set email
		if ($this->form->email_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['email']))
			{
				throw new Expection('Missing paramater: email');
			}

			// Check if this field is required
			if ($this->form->email_required and trim($this->params['email']) === '')
			{
				throw new Exception('Required field: email');
			}

			$lead->email = $this->params['email'];
		}

		// Validate and set phone
		if ($this->form->phone_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['phone']))
			{
				throw new Expection('Missing paramater: phone');
			}

			// Check if this field is required
			if ($this->form->phone_required and trim($this->params['phone']) === '')
			{
				throw new Exception('Required field: phone');
			}

			$lead->phone = $this->params['phone'];
		}

		// Validate and set address
		if ($this->form->address_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['address']))
			{
				throw new Expection('Missing paramater: address');
			}

			// Check if this field is required
			if ($this->form->address_required and trim($this->params['address']) === '')
			{
				throw new Exception('Required field: address');
			}

			$lead->address = $this->params['address'];
		}

		// Validate and set interest
		if ($this->form->interest_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['interest']))
			{
				throw new Expection('Missing paramater: interest');
			}

			// Check if this field is required
			if ($this->form->interest_required and trim($this->params['interest']) === '')
			{
				throw new Exception('Required field: interest');
			}

			$lead->interest = $this->params['interest'];
		}

		// Validate and set budget
		if ($this->form->budget_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['budget']))
			{
				throw new Expection('Missing paramater: budget');
			}

			// Check if this field is required
			if ($this->form->budget_required and trim($this->params['budget']) === '')
			{
				throw new Exception('Required field: budget');
			}

			$lead->budget = $this->params['budget'];
		}

		// Validate and set message
		if ($this->form->message_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['message']))
			{
				throw new Expection('Missing paramater: message');
			}

			// Check if this field is required
			if ($this->form->message_required and trim($this->params['message']) === '')
			{
				throw new Exception('Required field: message');
			}

			$lead->message = $this->params['message'];
		}

		// Validate and set referral
		if ($this->form->referral_enabled)
		{
			// Check for post paramater
			if (!isset($this->params['referral']))
			{
				throw new Expection('Missing paramater: referral');
			}

			// Check if this field is required
			if ($this->form->referral_required and trim($this->params['referral']) === '')
			{
				throw new Exception('Required field: referral');
			}

			$lead->referral = $this->params['referral'];
		}

		// Insert into database
		$lead->insert();

		return $lead;
	}

}