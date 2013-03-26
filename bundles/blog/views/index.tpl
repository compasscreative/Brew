<?
$this->title = 'Blog';
$this->insert('partials/header');
?>

<h1>Blog</h1>

<? if ($this->articles): ?>
    <div class="articles">
        <? foreach($this->articles as $article): ?>
            <div class="article">

                <h2><a href="<?=$e($article->url)?>"><?=$e($article->title)?></a></h2>

                <p>Published on <?=date_create($article->published_date)->format('F j, Y')?></p>

                <? if ($article->photo_url): ?>
                    <a href="<?=$e($article->url)?>">
                        <img src="<?=$e($article->photo_url)?>" alt="">
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

<?=$this->sidebar?>

<? $this->insert('partials/footer') ?>