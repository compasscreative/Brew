Blog
====

## Example Routes

```php
<?php
Router::get(
    '/blog',
    function () {

        // Create API
        $api = new \Brew\Blog\API();

        // Return view
        return Response::view(
            'blog/index',
            [
                'articles' => $api->getIndexArticles(),
                'categories' => $api->getCategories(),
                'sidebar_articles' => $api->getSidebarArticles()
            ]
        );
    }
);

Router::get(
    '/blog/([0-9]+)/([a-z-0-9]+)',
    function ($id, $slug) {

        // Create API
        $api = new \Brew\Blog\API();

        // Load article
        if (!$article = $api->getArticle($id)) {
            return Response::notFound();
        }

        // Validate slug
        if ($article->slug !== $slug) {
            return Response::redirect('/blog/' . $article->id . '/' . $article->slug);
        }

        // Return view
        return Response::view(
            'blog/article',
            [
                'article' => $article,
                'categories' => $api->getCategories()
            ]
        );
    }
);

Router::get(
    '/blog/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)',
    function ($size, $id) {

        // Create API
        $api = new \Brew\Blog\API();

        // Return photo
        return $api->getPhotoResponse($size, $id);
    }
);

Router::get(
    '/blog/category/([0-9]+)/([a-z-0-9]+)',
    function ($id, $slug) {

        // Create API
        $api = new \Brew\Blog\API();

        // Load category
        if (!$category = $api->getCategory($id, $slug)) {
            return Response::notFound();
        }

        // Validate slug
        if ($category->slug !== $slug) {
            return Response::redirect('/blog/category/' . $category->id . '/' . $category->slug);
        }

        // Return view
        return Response::view(
            'blog/category',
            [
                'category' => $category,
                'categories' => $api->getCategories()
            ]
        );
    }
);

Router::post(
    '/blog/search',
    function () {

        // Create API
        $api = new \Brew\Blog\API();

        // Load search
        if (!$search = $api->getSearchResults($_POST['query'])) {
            return Response::notFound();
        }

        // Return view
        return Response::view(
            'blog/search',
            [
                'search' => $search,
                'categories' => $api->getCategories()
            ]
        );
    }
);
```

## Example Views

### Index
```php
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
```

### Article
```php
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
```

### Category
```php
<?
$this->title = $e($this->category->name) . ' | Blog';
$this->insert('partials/header');
?>

<h1><?=$e($this->category->name)?></h1>

<? if ($this->category->articles): ?>
    <ul>
        <? foreach($this->category->articles as $article): ?>
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
    <p>Sorry, there are not articles in this category.</p>
<? endif ?>

<? $this->insert('blog/sidebar') ?>

<? $this->insert('partials/footer') ?>
```

### Search
```php
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
```

### Sidebar
```php
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
```