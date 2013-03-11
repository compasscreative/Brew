<?php
$this->title = $this->code . ': ' . $this->message . ' | Brew';
$this->insert('partials/header');
?>

<h1>Error <?=$this->code?></h1>

<p><?=$this->message?></p>

<?php $this->insert('partials/footer'); ?>