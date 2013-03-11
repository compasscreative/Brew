<?php

	namespace Brew\Bundle\Leads;

	use Brew\Bundle\Admin\Secure_Controller;
	use Reinink\Query\DB;
	use Reinink\Reveal\Response;

	class Admin_Controller extends Secure_Controller
	{
		public function index()
		{
			return Response::view('leads::admin/index', array
			(
				'leads' => DB::rows('SELECT id, name, email, phone, submitted_date FROM leads ORDER BY submitted_date DESC')
			));
		}

		public function edit($id)
		{
			if ($lead = DB::row('SELECT id, submitted_date, ip_address, name, email, phone, address, interest, budget, message, referral, url FROM leads WHERE id = ?', array($id)))
			{
				return Response::view('leads::admin/edit', array
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
				return Response::bad_request();
			}

			// Load the lead
			if (!$lead = Lead::select($_POST['id']))
			{
				return Response::not_found();
			}

			// Delete the lead
			$lead->delete();

			// Success
			return true;
		}
	}