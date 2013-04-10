<?
$this->title = 'Blog';
$this->insert('partials/header');
?>

<h1>Blog</h1>

<? if ($this->articles): ?>
    <div class="articles">
        <? foreach($this->articles as $article): ?>
            <div class="article">

                <h2><a href="/blog/<?=$e($article->id)?>/<?=$e($article->slug)?>"><?=$e($article->title)?></a></h2>

                <p>Published on <?=date_create($article->published_date)->format('F j, Y')?></p>

                <? if ($article->photo_id): ?>
                    <a href="/blog/<?=$e($article->id)?>/<?=$e($article->slug)?>">
                        <img src="/blog/photo/large/<?=$e($article->photo_id)?>" alt="<?=$e($article->photo_caption)?>">
                    </a>
                <? endif ?>

                <div class="body">
                    <?=$article->intro?>
                </div>

            </div>
        <? endforeach ?>
    </div>
<? else: ?>
    <p>No articles found.</p>
<? endif ?>

<? $this->insert('blog/sidebar') ?>

<? $this->insert('partials/footer') ?>