<?
$this->title = 'Galleries';
$this->insert('partials/header');
?>

<h1>Galleries</h1>

<ul>
	<? foreach($this->galleries as $gallery): ?>
		<li>
			<a href="<?=$e($gallery->url)?>">
				<img src="<?=$e($gallery->photo_url)?>" alt="<?=$e($gallery->photo_caption)?>">
				<h3><?=$e($gallery->title)?></h3>
			</a>
		</li>
	<? endforeach ?>
</ul>

<? $this->insert('partials/footer') ?>