<?
$this->title = $e($this->article->title) . ' | Blog';
$this->insert('partials/header');
?>

<div class="articles">
    <div class="article">

        <h1><?=$e($this->article->title)?></h1>

        <p>Published on <?=date_create($this->article->published_date)->format('F j, Y')?></p>

        <? if ($this->article->photos): ?>
            <img src="/blog/photo/large/<?=$e($this->article->photos[0]->id)?>" alt="<?=$e($this->article->photos[0]->caption)?>" />
        <? endif ?>

        <? if (array_slice($this->article->photos, 1)): ?>
            <ul>
                <? foreach (array_slice($this->article->photos, 1) as $photo): ?>
                    <li>
                        <a href="/blog/photo/xlarge/<?=$e($photo->id)?>" title="<?=$e($photo->caption)?>">
                            <img src="/blog/photo/small/<?=$e($photo->id)?>" alt="<?=$e($photo->caption)?>" />
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

<? $this->insert('blog/sidebar') ?>

<? $this->insert('partials/footer') ?>