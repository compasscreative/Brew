<?
$this->title = 'Projects';
$this->insert('partials/header');
?>

<h1>Projects</h1>

<? if ($this->projects): ?>
    <ul>
    	<? foreach($this->projects as $project): ?>
    		<li>
    			<a href="<?=$e($project->url)?>">
    				<img src="<?=$e($project->photo_url)?>" alt="<?=$e($project->photo_caption)?>">
    				<h3><?=$e($project->title)?></h3>
                    <p><?=$e($project->introduction)?></p>
    			</a>
    		</li>
    	<? endforeach ?>
    </ul>
<? else: ?>
    <p>No projects found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>