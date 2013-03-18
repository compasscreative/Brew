<?php
use Reinink\Deets\Config;

$this->title = 'Leads | Brew';
$this->insert('partials/header');
?>

<h1>Leads</h1>

<?php
    $forms = Config::get('leads::forms');
    echo $forms['contact']->render('contact')
?>

<?php $this->insert('partials/footer');
