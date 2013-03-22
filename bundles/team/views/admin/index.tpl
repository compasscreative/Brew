<?
$this->title = 'Team';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Team</div>
        <ul class="menu">
            <li><a href="/admin/team/add">Add new team member</a></li>
        </ul>
    </div>
    <div class="body">
        <form autocomplete="off" id="team_index">
            <? if ($this->team_members): ?>
                <ul>
                    <? foreach ($this->team_members as $team_member): ?>
                        <li>
                            <input type="hidden" name="team_members[]" value="<?=$e($team_member->id)?>">
                            <a href="/admin/team/edit/<?=$e($team_member->id)?>/">
                                <? if ($team_member->photo_url): ?>
                                    <img src="<?=$e($team_member->photo_url)?>">
                                <?php else: ?>
                                    <div class="no_photo"></div>
                                <? endif ?>
                                <span><?=$e($team_member->first_name)?> <?=$e($team_member->last_name)?></span>
                            </a>
                        </li>
                    <? endforeach ?>
                </ul>
            <? else: ?>
                <p>No team members found.</p>
            <? endif ?>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>