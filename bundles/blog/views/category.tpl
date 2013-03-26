<?
$this->title = $e($this->category->name) . ' | Blog';
$this->insert('partials/header');
?>

<h1><?=$e($this->category->name)?></h1>

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
<? endif ?>

<?=$this->sidebar?>

<? $this->insert('partials/footer') ?>