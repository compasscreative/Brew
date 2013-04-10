<?php

namespace Brew\Leads;

use Reinink\Trailmix\Config;

/*
|--------------------------------------------------------------------------
| Form definitions
|--------------------------------------------------------------------------
*/

// Contact form
Config::$values['leads::forms']['contact'] = new LeadForm('contact', '/thank-you');
// Config::$values['leads::forms']['contact']->setFrom('John Doe', 'john@doe.com');
// Config::$values['leads::forms']['contact']->setRecipients(array('john@doe.com'));
Config::$values['leads::forms']['contact']->enableName(true);
Config::$values['leads::forms']['contact']->enableEmail(true);
Config::$values['leads::forms']['contact']->enablePhone();
Config::$values['leads::forms']['contact']->enableAddress();
Config::$values['leads::forms']['contact']->enableMessage();
