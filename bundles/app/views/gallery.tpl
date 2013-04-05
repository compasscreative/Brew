<?
$this->title = $e($this->gallery->title);
$this->insert('partials/header');
?>

<h1><?=$e($this->gallery->title)?></h1>

<h2>Description:</h2>
<p><?=$this->gallery->description?></p>

<h2>Photos:</h2>
<ul>
    <? foreach ($this->photos as $photo): ?>
        <li>
            <a href="/galleries/photo/xlarge/<?=$e($photo->id)?>" title="<?=$e($photo->caption)?>">
                <img src="/galleries/photo/small/<?=$e($photo->id)?>" alt="<?=$e($photo->caption)?>" />
            </a>
        </li>
    <? endforeach ?>
</ul>

<h2>Other galleries:</h2>
<ul>
    <? foreach($this->galleries as $gallery): ?>
        <li>
            <a href="/galleries/<?=$e($gallery->id)?>/<?=$e($gallery->slug)?>">
                <img src="/galleries/photo/small/<?=$e($gallery->photo_id)?>" alt="<?=$e($gallery->photo_caption)?>">
                <h3><?=$e($gallery->title)?></h3>
            </a>
        </li>
    <? endforeach ?>
</ul>

<? $this->insert('partials/footer') ?>