<?
$this->title = 'Galleries';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Galleries</div>
        <ul class="menu">
            <li><a href="/admin/galleries/add">Add new gallery</a></li>
        </ul>
    </div>
    <div class="body">
        <form autocomplete="off">
            <ul class="table">
                <li class="headings">
                    <div style="width: 75%;">Name</div>
                    <div style="width: 25%;">Photos</div>
                </li>
                <? if ($this->galleries): ?>
                    <? foreach ($this->galleries as $gallery): ?>
                        <li id="<?=$e($gallery->id)?>">
                            <div style="width: 75%;">
                                <span class="drag_handle">&#9776;</span>
                                <a href="/admin/galleries/edit/<?=$e($gallery->id)?>/"><?=$e($gallery->title)?></a>
                            </div>
                            <div style="width: 25%;"><?=$e($gallery->photos)?></div>
                        </li>
                    <? endforeach ?>
                <? else: ?>
                    <li>
                        <div>No galleries found.</div>
                    </li>
                <? endif ?>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>