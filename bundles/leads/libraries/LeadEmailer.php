<?php
namespace Brew\Leads;

class LeadEmailer
{
    private $lead;
    private $form;

    public function __construct(Lead $lead, Form $form)
    {
        $this->lead = $lead;
        $this->form = $form;
    }

    public function send()
    {
        // Build headers
        $headers = "From: " . $this->form->from_name . " <" . $this->form->from_email . ">\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8;";

        // Build message
        $message = '';

        // Add message
        if (strlen($this->lead->message)) {
            $message .= $this->lead->message . "\n\n";
            $message .= "--------------------\n";
        }

        // Add name
        if (strlen($this->lead->name)) {
            $message .= "Name: " . $this->lead->name . "\n";
        }

        // Add email
        if (strlen($this->lead->email)) {
            $message .= "Email: " . $this->lead->email . "\n";
        }

        // Add phone
        if (strlen($this->lead->phone)) {
            $message .= "Phone: " . $this->lead->phone . "\n";
        }

        // Add address
        if (strlen($this->lead->address)) {
            $message .= "Address: " . $this->lead->address . "\n";
        }

        // Add interest
        if (strlen($this->lead->interest)) {
            $message .= "Interest: " . $this->lead->interest . "\n";
        }

        // Add budget
        if (strlen($this->lead->budget)) {
            $message .= "Budget: " . $this->lead->budget . "\n";
        }

        // Add referral
        if (strlen($this->lead->referral)) {
            $message .= "Referral: " . $this->lead->referral . "\n";
        }

        // Add url
        if (strlen($this->lead->url)) {
            $message .= "Submitted from: " . $this->lead->url . "\n";
        }

        // Send email
        mail(implode(', ', $this->form->recipients), 'Website Lead', $message, $headers);

        return true;
    }
}
