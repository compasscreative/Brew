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
        <form autocomplete="off" id="team_index">
            <? foreach ($this->categories as $category): ?>

                <? if (count($this->categories)): ?>
                    <h2><?=$category === '' ? 'Uncategorized' : $category?></h2>
                <? endif ?>

                <ul data-name="<?=$category?>">
                    <? foreach ($this->members as $member): ?>

                        <? if ($member->category !== $category) continue; ?>

                        <li id="<?=$member->id?>">
                            <a href="/admin/team/edit/<?=$e($member->id)?>/">
                                <? if ($member->photo_url): ?>
                                    <img src="<?=$e($member->photo_url)?>">
                                <?php else: ?>
                                    <div class="no_photo"></div>
                                <? endif ?>
                                <span><?=$e($member->first_name)?> <?=$e($member->last_name)?></span>
                            </a>
                        </li>

                    <? endforeach ?>
                </ul>
            <? endforeach ?>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>