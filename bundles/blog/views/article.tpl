<?
$this->title = $e($this->article->title) . ' | Blog';
$this->insert('partials/header');
?>

<div class="articles">
    <div class="article">

        <h1><?=$e($this->article->title)?></h1>

        <p>Published on <?=date_create($this->article->published_date)->format('F j, Y')?></p>

        <? if ($this->photos): ?>
            <img src="<?=$e($this->photos[0]->large_url)?>" alt="<?=$e($this->photos[0]->caption)?>" />
        <? endif ?>

        <? if (array_slice($this->photos, 1)): ?>
            <ul>
                <? foreach (array_slice($this->photos, 1) as $photo): ?>
                    <li>
                        <a href="<?=$e($photo->xlarge_url)?>" title="<?=$e($photo->caption)?>">
                            <img src="<?=$e($photo->small_url)?>" alt="<?=$e($photo->caption)?>" />
                        </a>
                    </li>
                <? endforeach ?>
            </ul>
        <? endif ?>

        <div class="body">
            <?=$this->article->body?>
        </div>
    </div>
</div>

<?=$this->sidebar?>

<? $this->insert('partials/footer') ?>