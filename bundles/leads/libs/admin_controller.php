<?php namespace Brew\Bundle\Leads;

use Brew\Bundle\Admin\Secure_Controller;
use Reinink\Reveal\Response;

class Admin_Controller extends Secure_Controller
{
	public function index()
	{
		return Response::view('leads::admin/index', array
		(
			'leads' => Lead::select('id, name, email, phone, submitted_date')->order_by('submitted_date DESC')->rows()
		));
	}

	public function edit($id)
	{
		if ($lead = Lead::select('id, submitted_date, ip_address, name, email, phone, address, interest, budget, message, referral, url')->id($id)->row())
		{
			return Response::view('leads::admin/edit', array
			(
				'lead' => $lead
			));
		}
	}

	public function delete()
	{
		if (!isset($_POST['id']))
		{
			Response::bad_request();
		}

		if (!$lead = Lead::select($_POST['id']))
		{
			Response::not_found();
		}

		$lead->delete();

		return true;
	}
}