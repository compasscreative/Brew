<?
$this->title = 'Team';
$this->insert('partials/header');
?>

<h1>Team</h1>

<? if ($this->team_members): ?>
    <? foreach ($this->team_categories as $category): ?>
        <h2><?=$e($category)?></h2>
        <ul>
            <? foreach ($this->team_members as $team_member): ?>
                <? if ($team_member->category !== $category) continue; ?>
                <li id="<?=$team_member->id?>">
                    <a href="/admin/team/edit/<?=$e($team_member->id)?>/">
                        <? if ($team_member->has_photo): ?>
                            <img src="/team/photo/small/<?=$e($team_member->id)?>" alt="<?=$e($team_member->first_name)?> <?=$e($team_member->last_name)?>">
                        <?php else: ?>
                            <!-- Insert blank photo here -->
                        <? endif ?>
                        <h3><?=$e($team_member->first_name)?> <?=$e($team_member->last_name)?></h3>
                        <h4><?=$e($team_member->title)?></h4>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    <? endforeach ?>
<? else: ?>
    <p>No team members found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>