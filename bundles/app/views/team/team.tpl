<?
$this->title = 'Team';
$this->insert('partials/header');
?>

<h1>Team</h1>

<? if ($this->categories): ?>
    <? foreach ($this->categories as $category): ?>
        <h2><?=$e($category->name)?></h2>
        <ul>
            <? foreach ($category->members as $member): ?>
                <li id="<?=$member->id?>">
                    <a href="/team/<?=$e($member->id)?>/<?=$e($member->slug)?>">
                        <? if ($member->has_photo): ?>
                            <img src="/team/photo/small/<?=$e($member->id)?>" alt="<?=$e($member->first_name)?> <?=$e($member->last_name)?>">
                        <?php else: ?>
                            <!-- Insert blank photo here -->
                        <? endif ?>
                        <h3><?=$e($member->first_name)?> <?=$e($member->last_name)?></h3>
                        <h4><?=$e($member->title)?></h4>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    <? endforeach ?>
<? else: ?>
    <p>No team members found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>