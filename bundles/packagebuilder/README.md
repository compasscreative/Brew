Package Builder
===============

## Example Routes

```php
<?php

Router::get(
    '/package-builder',
    function () {

        // Create API
        $api = new \Brew\PackageBuilder\API();

        // Get form
        $form = $api->getForm('/package-builder');

        // Return view
        return Response::view(
            'package_builder',
            [
                'form' => $form
            ]
        );
    }
);

Router::get(
    '/package-builder/photo/(large|small)/(small|medium|large)/([0-9]+)/[0-9]+',
    function ($image_size, $option_size, $id) {

        // Create API
        $api = new \Brew\PackageBuilder\API();

        // Return photo
        return $api->getPhotoResponse($image_size, $option_size, $id);
    }
);
```

## Example View

```php
<?
$this->title = 'Package Builder';
$this->insert('partials/header');
?>

<h1>Package Builder</h1>

<?=$this->form?>

<? $this->insert('partials/footer') ?>
```