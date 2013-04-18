<?
$this->title = 'Galleries';
$this->insert('partials/header');
?>

<h1>Galleries</h1>

<? if ($this->galleries): ?>
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
<? else: ?>
    <p>No galleries found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>