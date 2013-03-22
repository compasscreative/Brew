<?
$this->title = $e($this->team_member->first_name) . ' ' . $e($this->team_member->last_name) . ' | Team';
$this->insert('partials/header');
?>

<? if ($this->team_member->photo_url): ?>
    <img src="<?=$this->team_member->photo_url?>">
<? endif ?>

<h1><?=$e($this->team_member->first_name)?> <?=$e($this->team_member->last_name)?></h1>

<h2>Title:</h2>
<p><?=$this->team_member->title?></p>

<h2>Bio:</h2>
<p><?=$this->team_member->bio?></p>

<h2>Email:</h2>
<p><?=$this->team_member->email?></p>

<h2>Phone:</h2>
<p><?=$this->team_member->phone?></p>

<? $this->insert('partials/footer') ?>