<?
$this->title = strlen($this->product->title_tag) ? $e($this->product->title_tag) : $e($this->product->title);
$this->description = $e($this->product->description_tag);
$this->insert('partials/header');
?>

<h1><?=$e($this->product->title)?></h1>

<? if ($this->product->introduction): ?>
    <h2>Introduction:</h2>
    <?=$this->product->introduction?>
<? endif ?>

<? if ($this->product->description): ?>
    <h2>Description:</h2>
    <?=$this->product->description?>
<? endif ?>

<h2>Photos:</h2>
<ul>
    <? foreach ($this->photos as $photo): ?>
        <li>
            <a href="/products/photo/xlarge/<?=$e($photo->id)?>" title="<?=$e($photo->caption)?>">
                <img src="/products/photo/small/<?=$e($photo->id)?>" alt="<?=$e($photo->caption)?>" />
            </a>
        </li>
    <? endforeach ?>
</ul>

<h2>Other products:</h2>
<ul>
    <? foreach($this->products as $product): ?>
        <li>
            <a href="/products/<?=$e($product->slug)?>">
                <img src="/products/photo/small/<?=$e($product->photo_id)?>" alt="<?=$e($product->photo_caption)?>">
                <h3><?=$e($product->title)?></h3>
            </a>
        </li>
    <? endforeach ?>
</ul>

<? $this->insert('partials/footer') ?>