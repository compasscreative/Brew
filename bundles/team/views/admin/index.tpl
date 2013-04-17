<?
$this->title = 'Team';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Team</div>
        <ul class="menu">
            <li><a href="/admin/team/add">Add new member</a></li>
        </ul>
    </div>
    <div class="body">
        <form autocomplete="off">
            <? foreach ($this->categories as $category): ?>
                <? if (count($this->categories) > 1): ?>
                    <h2><?=$category === '' ? 'Uncategorized' : $category?></h2>
                <? endif ?>
                <ul class="table" data-name="<?=$category?>">
                    <li class="headings">
                        <div style="width: 27%;">Name</div>
                        <div style="width: 27%;">Title</div>
                        <div style="width: 26%;">Email</div>
                        <div style="width: 20%;">Phone</div>
                    </li>
                    <? foreach ($this->members as $member): ?>
                        <? if ($member->category !== $category) continue; ?>
                        <li id="<?=$member->id?>">
                            <div style="width: 27%;"><span class="drag_handle">&#9776;</span> <a href="/admin/team/edit/<?=$e($member->id)?>/"><?=$e($member->first_name)?> <?=$e($member->last_name)?></a></div>
                            <div style="width: 27%;"><?=$e($member->title)?></div>
                            <div style="width: 26%;"><?=$e($member->email)?></div>
                            <div style="width: 20%;"><?=$e($member->phone)?></div>
                        </li>
                    <? endforeach ?>
                </ul>
            <? endforeach ?>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>