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
			<a href="<?=$e($photo->xlarge_url)?>" title="<?=$e($photo->caption)?>">
				<img src="<?=$e($photo->small_url)?>" alt="<?=$e($photo->caption)?>" />
			</a>
		</li>
	<? endforeach ?>
</ul>

<h2>Other galleries:</h2>
<ul>
	<? foreach($this->other_galleries as $gallery): ?>
		<li>
			<a href="<?=$e($gallery->url)?>">
				<img src="<?=$e($gallery->photo_url)?>" alt="<?=$e($gallery->photo_caption)?>">
				<h3><?=$e($gallery->title)?></h3>
			</a>
		</li>
	<? endforeach ?>
</ul>

<? $this->insert('partials/footer') ?>