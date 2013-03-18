<?php
use Reinink\Deets\Config;

$this->insert('partials/header');
?>

<h1><?=$this->title?></h1>

<?php if (is_callable('Reinink\Deets\Config::get') and Config::get('display_errors')) { ?>
    <h3>Message:</h3>
    <p><?=$this->exception->getMessage()?></p>

    <h3>Location:</h3>
    <pre>Line <?=$this->exception->getLine()?> on <?=$this->exception->getFile()?></pre>

    <h3>Stack Trace:</h3>
    <pre><?=$this->exception->getTraceAsString()?></pre>
<?php } ?>

<?php $this->insert('partials/footer');
