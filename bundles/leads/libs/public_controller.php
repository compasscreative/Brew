<?php

namespace Brew\Bundle\Leads;

use Brew\Bundle\Leads\Email_Lead;
use Brew\Bundle\Leads\Process_Lead;
use Reinink\Utils\Config;

class Public_Controller
{
	public function process()
	{
		// Get array of forms
		$forms = Config::get('leads::forms');

		// Verify that the form exists
		if (isset($forms[$_POST['id']]))
		{
			// Get the form
			$form = $forms[$_POST['id']];

			// Process the lead
			$process = new Process_Lead($form, $_POST);
			$lead = $process->process();

			// Email the lead
			if ($form->recipients)
			{
				$email = new Email_Lead($lead, $form);
				$email->send();
			}

			return true;
		}
		else
		{
			return false;
		}
	}
}