<?
$this->title = $e($this->project->title);
$this->insert('partials/header');
?>

<h1><?=$e($this->project->title)?></h1>

<h2>Completed date:</h2>
<p><?=$e($this->project->completed_date)?></p>

<h2>Description:</h2>
<p><?=$this->project->description?></p>

<h2>Photos:</h2>
<ul>
    <? foreach ($this->photos as $photo): ?>
        <li>
            <a href="<?=$e($photo->xlarge_url)?>" title="<?=$e($photo->caption)?>">
                <img src="<?=$e($photo->small_url)?>" alt="<?=$e($photo->caption)?>" />
            </a>
        </li>
    <? endforeach ?>
</ul>

<? $this->insert('partials/footer') ?>