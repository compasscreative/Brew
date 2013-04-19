<?
$this->title = 'Products';
$this->insert('partials/header');
?>

<h1>Products</h1>

<? if ($this->products): ?>
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
<? else: ?>
    <p>No products found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>