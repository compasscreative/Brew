<?php

	namespace Brew\Bundle\Leads;

	use \Exception;
	use Brew\Bundle\Admin\Secure_Controller;
	use Brew\Bundle\Leads\Lead;
	use Reinink\Query\DB;
	use Reinink\Reveal\View;

	class Admin_Controller extends Secure_Controller
	{
		public function index()
		{
			return View::make('leads::admin/index', array
			(
				'leads' => DB::rows('SELECT id, name, email, phone, date FROM leads ORDER BY date DESC')
			));
		}

		public function edit($id)
		{
			if ($lead = DB::row('SELECT id, date, ip_address, name, email, phone, address, interest, budget, message, referral, url FROM leads WHERE id = ?', array($id)))
			{
				return View::make('leads::admin/edit', array
				(
					'lead' => $lead
				));
			}
		}

		public function delete()
		{
			// Check for required post variables
			if (!isset($_POST['id']))
			{
				return false;
			}

			// Load the lead
			if (!$lead = Lead::select($_POST['id']))
			{
				return false;
			}

			// Delete the lead
			$lead->delete();

			return true;
		}
	}