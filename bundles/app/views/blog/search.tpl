<?
$this->title = 'Search for &ldquo;' . $e($this->search->query) . '&rdquo; | Blog';
$this->insert('partials/header');
?>

<h1>Search for &ldquo;<?=$e($this->search->query)?>&rdquo;</h1>

<? if ($this->search->articles): ?>
    <ul>
        <? foreach($this->search->articles as $article): ?>
            <li>
                <div class="photo">
                    <? if ($article->photo_id): ?>
                        <a href="/blog/<?=$e($article->id)?>/<?=$e($article->slug)?>">
                            <img src="/blog/photo/medium/<?=$e($article->photo_id)?>" alt="<?=$e($article->photo_caption)?>">
                        </a>
                    <? endif ?>
                </div>

                <div class="title">
                    <a href="/blog/<?=$e($article->id)?>/<?=$e($article->slug)?>"><?=$e($article->title)?></a>
                </div>

                <div class="date">
                    <?=date_create($article->published_date)->format('F j, Y')?>
                </div>
            </li>
        <? endforeach ?>
    </ul>
<? else: ?>
    <p>Sorry, no articles were found.</p>
<? endif ?>

<? $this->insert('blog/sidebar') ?>

<? $this->insert('partials/footer') ?>