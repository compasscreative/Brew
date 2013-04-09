<?
$this->title = 'Package Builder';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Package Builder</div>
        <ul class="menu">
            <li><a href="/admin/package-builder/add">Add option</a></li>
        </ul>
    </div>
    <div class="body">
        <form autocomplete="off" id="packagebuilder_index">
            <? foreach ($this->sections as $section): ?>
                <h2><?=$e($section->name)?></h2>
                <ul class="table">
                    <li class="headings">
                        <div style="width: 20%;">Name</div>
                        <div style="width: 20%;">Section</div>
                        <div style="width: 20%;">Small</div>
                        <div style="width: 20%;">Medium</div>
                        <div style="width: 20%;">Large</div>
                    </li>
                    <? foreach ($section->options as $option): ?>
                        <li id="<?=$e($option->id)?>">
                            <div style="width: 20%;"><span class="drag_handle">&#9776;</span> <a href="/admin/package-builder/edit/<?=$option->id?>/"><?=$e($option->name)?></a></div>
                            <div style="width: 20%;"><?=$e($option->section)?></div>
                            <div style="width: 20%;">$<?=$e($option->small_price_1)?> to $<?=$e($option->small_price_2)?></div>
                            <div style="width: 20%;">$<?=$e($option->medium_price_1)?> to $<?=$e($option->medium_price_2)?></div>
                            <div style="width: 20%;">$<?=$e($option->large_price_1)?> to $<?=$e($option->large_price_2)?></div>
                        </li>
                    <? endforeach ?>
                </ul>
            <? endforeach ?>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>