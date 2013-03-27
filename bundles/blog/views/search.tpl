<?
$this->title = 'Search for &ldquo;' . $e($this->query) . '&rdquo; | Blog';
$this->insert('partials/header');
?>

<h1>Search for &ldquo;<?=$e($this->query)?>&rdquo;</h1>

<? if ($this->articles): ?>
    <ul>
        <? foreach($this->articles as $article): ?>
            <li>
                <div class="photo">
                    <? if ($article->photo_url): ?>
                        <a href="<?=$e($article->url)?>">
                            <img src="<?=$e($article->photo_url)?>" alt="">
                        </a>
                    <? endif ?>
                </div>

                <div class="title">
                    <a href="<?=$e($article->url)?>"><?=$e($article->title)?></a>
                </div>

                <div class="date">
                    <?=date_create($article->published_date)->format('F j, Y')?>
                </div>
            </li>
        <? endforeach ?>
    </ul>
<? else: ?>
    <p>Sorry, no results were found.</p>
<? endif ?>

<?=$this->sidebar?>

<? $this->insert('partials/footer') ?>