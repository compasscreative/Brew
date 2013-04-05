<?php
namespace Brew\App;

use Reinink\Routy\Router;
use Reinink\Reveal\Response;

Router::get(
    '/',
    function () {
        return Response::view('home');
    }
);

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

Router::get(
    '/contact',
    function () {
        return Response::view('contact');
    }
);
