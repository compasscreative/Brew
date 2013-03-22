<?
$this->title = 'Team';
$this->insert('partials/header');
?>

<h1>Team</h1>

<? if ($this->team_members): ?>
    <ul>
    	<? foreach($this->team_members as $team_members): ?>
    		<li>
    			<a href="<?=$e($team_members->page_url)?>">
                    <? if ($team_members->photo_url): ?>
    				    <img src="<?=$e($team_members->photo_url)?>" alt="<?=$e($team_members->first_name)?> <?=$e($team_members->last_name)?>">
                    <? endif ?>
    				<h3><?=$e($team_members->first_name)?> <?=$e($team_members->last_name)?></h3>
    			</a>
    		</li>
    	<? endforeach ?>
    </ul>
<? else: ?>
    <p>No team members found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>