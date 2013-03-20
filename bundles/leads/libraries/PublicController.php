<?php
namespace Brew\Leads;

use Reinink\Trailmix\Config;

class PublicController
{
    public function process()
    {
        // Get array of forms
        $forms = Config::get('leads::forms');

        // Verify that the form exists
        if (isset($forms[$_POST['id']])) {

            // Get the form
            $form = $forms[$_POST['id']];

            // Process the lead
            $process = new LeadProcessor($form, $_POST);
            $lead = $process->process();

            // Email the lead
            if ($form->recipients) {
                $email = new LeadEmailer($lead, $form);
                $email->send();
            }

            // Success
            return true;
        }
    }
}
