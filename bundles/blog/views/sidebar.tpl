<hr>

<div class="sidebar">

    <h3>Search</h3>
    <form>
        <input type="text">
        <button>Search</button>
    </form>

    <h3>Categories:</h3>
    <? if ($this->categories): ?>
        <ul class="categories">
            <? foreach ($this->categories as $category): ?>
                <li>
                    <a href="<?=$e($category->url)?>">
                        <?=$e($category->name)?>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    <? endif ?>

    <h3>Other articles:</h3>
    <? if ($this->other_articles): ?>
        <ul>
            <? foreach($this->other_articles as $other_article): ?>
                <li>
                    <div class="photo">
                        <? if ($other_article->photo_url): ?>
                            <a href="<?=$e($other_article->url)?>">
                                <img src="<?=$e($other_article->photo_url)?>" alt="">
                            </a>
                        <? endif ?>
                    </div>

                    <div class="title">
                        <a href="<?=$e($other_article->url)?>"><?=$e($other_article->title)?></a>
                    </div>

                    <div class="date">
                        <?=date_create($other_article->published_date)->format('F j, Y')?>
                    </div>
                </li>
            <? endforeach ?>
        </ul>
    <? endif ?>
</div>