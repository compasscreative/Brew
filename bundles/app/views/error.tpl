<?
$this->title = 'Error ' . $this->exception->getCode();
$this->insert('partials/header');
?>

<h1><?=$this->title?></h1>
<p><?=$this->exception->getMessage()?></p>

<? $this->insert('partials/footer')?>