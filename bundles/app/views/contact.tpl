<?
$this->title = 'Contact';
$this->insert('partials/header');
?>

<h1>Contact</h1>

<?=Config::get('leads::forms')['contact']?>

<? $this->insert('partials/footer') ?>