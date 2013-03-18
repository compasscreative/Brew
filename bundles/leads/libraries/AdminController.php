<?php
namespace Brew\Leads;

use Brew\Admin\SecureController;
use Reinink\Reveal\Response;

class AdminController extends SecureController
{
    public function index()
    {
        $leads = Lead::select('id, name, email, phone, submitted_date')
                     ->orderBy('submitted_date DESC')
                     ->rows();

        return Response::view('leads::admin/index', array('leads' => $leads));
    }

    public function edit($id)
    {
        if ($lead = Lead::select('id, submitted_date, ip_address, name, email, phone, address, interest, budget, message,referral, url')
                        ->where('id', $id)
                        ->row()) {

            return Response::view('leads::admin/edit', array('lead' => $lead));
        }
    }

    public function delete()
    {
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        if (!$lead = Lead::select($_POST['id'])) {
            Response::notFound();
        }

        $lead->delete();

        return true;
    }
}
