<?
$this->title = 'Products';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Products</div>
        <ul class="menu">
            <li><a href="/admin/products/add">Add new product</a></li>
        </ul>
    </div>
    <div class="body">
        <form autocomplete="off">
            <ul class="table">
                <li class="headings">
                    <div style="width: 75%;">Name</div>
                    <div style="width: 25%;">Photos</div>
                </li>
                <? if ($this->products): ?>
                    <? foreach ($this->products as $product): ?>
                        <li id="<?=$e($product->id)?>">
                            <div style="width: 75%;">
                                <span class="drag_handle">&#9776;</span>
                                <a href="/admin/products/edit/<?=$e($product->id)?>/"><?=$e($product->title)?></a>
                            </div>
                            <div style="width: 25%;"><?=$e($product->photos)?></div>
                        </li>
                    <? endforeach ?>
                <? else: ?>
                    <li>
                        <div>No products found.</div>
                    </li>
                <? endif ?>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>