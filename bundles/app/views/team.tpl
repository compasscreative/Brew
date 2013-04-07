<?
$this->title = 'Team';
$this->insert('partials/header');
?>

<h1>Team</h1>

<? if ($this->team_members): ?>
    <ul>
    	<? foreach($this->team_members as $team_member): ?>
    		<li>
    			<a href="/team/<?=$e($team_member->id)?>/<?=$e($team_member->slug)?>">
                    <? if ($team_member->has_photo): ?>
    				    <img src="/team/photo/small/<?=$e($team_member->id)?>" alt="<?=$e($team_member->first_name)?> <?=$e($team_member->last_name)?>">
                    <? endif ?>
    				<h3><?=$e($team_member->first_name)?> <?=$e($team_member->last_name)?></h3>
    			</a>
    		</li>
    	<? endforeach ?>
    </ul>
<? else: ?>
    <p>No team members found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>