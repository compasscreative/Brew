Galleries
=========

## Example Routes

```php
<?php
Router::get(
    '/galleries',
    function () {

        // Create API
        $api = new \Brew\Galleries\API();

        // Load all galleries
        $galleries = $api->getAllGalleries();

        // Return view
        return Response::view(
            'galleries',
            [
                'galleries' => $galleries
            ]
        );
    }
);

Router::get(
    '/galleries/([0-9]+)/([a-z-0-9]+)',
    function ($id, $slug) {

        // Create API
        $api = new \Brew\Galleries\API();

        // Load gallery
        if (!$gallery = $api->getGallery($id)) {
            return Response::notFound();
        }

        // Validate slug
        if ($gallery->slug !== $slug) {
            return Response::redirect('/galleries/' . $gallery->id . '/' . $gallery->slug);
        }

        // Load photos
        if (!$photos = $api->getGalleryPhotos($gallery->id)) {
            return Response::notFound();
        }

        // Load all galleries
        $galleries = $api->getAllGalleries();

        // Return view
        return Response::view(
            'gallery',
            [
                'gallery' => $gallery,
                'photos' => $photos,
                'galleries' => $galleries
            ]
        );
    }
);

Router::get(
    '/galleries/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)',
    function ($size, $id) {

        // Create API
        $api = new \Brew\Galleries\API();

        // Return photo
        return $api->getPhotoResponse($size, $id);
    }
);
```

## Example Views

### Index Page
```php
<?
$this->title = 'Galleries';
$this->insert('partials/header');
?>

<h1>Galleries</h1>

<? if ($this->galleries): ?>
    <ul>
        <? foreach($this->galleries as $gallery): ?>
            <li>
                <a href="/galleries/<?=$e($gallery->id)?>/<?=$e($gallery->slug)?>">
                    <img src="/galleries/photo/small/<?=$e($gallery->photo_id)?>" alt="<?=$e($gallery->photo_caption)?>">
                    <h3><?=$e($gallery->title)?></h3>
                </a>
            </li>
        <? endforeach ?>
    </ul>
<? else: ?>
    <p>No galleries found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>
```

### Gallery Page

```php
<?
$this->title = $e($this->gallery->title);
$this->insert('partials/header');
?>

<h1><?=$e($this->gallery->title)?></h1>

<? if ($this->gallery->description): ?>
    <h2>Description:</h2>
    <?=$this->gallery->description?>
<? endif ?>

<h2>Photos:</h2>
<ul>
    <? foreach ($this->photos as $photo): ?>
        <li>
            <a href="/galleries/photo/xlarge/<?=$e($photo->id)?>" title="<?=$e($photo->caption)?>">
                <img src="/galleries/photo/small/<?=$e($photo->id)?>" alt="<?=$e($photo->caption)?>" />
            </a>
        </li>
    <? endforeach ?>
</ul>

<h2>Other galleries:</h2>
<ul>
    <? foreach($this->galleries as $gallery): ?>
        <li>
            <a href="/galleries/<?=$e($gallery->id)?>/<?=$e($gallery->slug)?>">
                <img src="/galleries/photo/small/<?=$e($gallery->photo_id)?>" alt="<?=$e($gallery->photo_caption)?>">
                <h3><?=$e($gallery->title)?></h3>
            </a>
        </li>
    <? endforeach ?>
</ul>

<? $this->insert('partials/footer') ?>
```