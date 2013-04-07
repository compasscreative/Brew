<?
$this->title = $e($this->team_member->first_name) . ' ' . $e($this->team_member->last_name) . ' | Team';
$this->insert('partials/header');
?>

<? if ($this->team_member->has_photo): ?>
    <img src="/team/photo/medium/<?=$e($this->team_member->id)?>">
<? endif ?>

<h1><?=$e($this->team_member->first_name)?> <?=$e($this->team_member->last_name)?></h1>

<? if ($this->team_member->title): ?>
    <h2>Title:</h2>
    <p><?=$e($this->team_member->title)?></p>
<? endif ?>

<? if ($this->team_member->bio): ?>
    <h2>Bio:</h2>
    <?=$this->team_member->bio?>
<? endif ?>

<? if ($this->team_member->email): ?>
    <h2>Email:</h2>
    <p><a href="mailto:<?=$e($this->team_member->email)?>"><?=$e($this->team_member->email)?></a></p>
<? endif ?>

<? if ($this->team_member->phone): ?>
    <h2>Phone:</h2>
    <p><?=$e($this->team_member->phone)?></p>
<? endif ?>

<? $this->insert('partials/footer') ?>