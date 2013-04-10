<hr>

<div class="sidebar">

    <h3>Search</h3>
    <form action="/blog/search" method="post">
        <input type="text" name="query">
        <button type="submit">Search</button>
    </form>

    <? if (isset($this->categories) and $this->categories): ?>
        <h3>Categories:</h3>
        <ul class="categories">
            <? foreach ($this->categories as $category): ?>
                <li>
                    <a href="/blog/category/<?=$e($category->id)?>/<?=$e($category->slug)?>">
                        <?=$e($category->name)?>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    <? endif ?>

    <? if (isset($this->sidebar_articles) and $this->sidebar_articles): ?>
        <h3>Recent articles:</h3>
        <ul>
            <? foreach($this->sidebar_articles as $article): ?>
                <li>
                    <div class="photo">
                        <? if ($article->photo_id): ?>
                            <a href="/blog/<?=$e($article->id)?>/<?=$e($article->slug)?>">
                                <img src="/blog/photo/small/<?=$e($article->photo_id)?>" alt="<?=$e($article->photo_caption)?>">
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
    <? endif ?>
</div>