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

/*
|--------------------------------------------------------------------------
| Galleries
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Team
|--------------------------------------------------------------------------
*/

Router::get(
    '/team',
    function () {

        // Create API
        $api = new \Brew\Team\API();

        // Load all team members
        $team_members = $api->getAllTeamMembers();

        // Return view
        return Response::view(
            'team',
            [
                'team_members' => $team_members
            ]
        );
    }
);

Router::get(
    '/team/([0-9]+)/([a-z-0-9]+)',
    function ($id, $slug) {

        // Create API
        $api = new \Brew\Team\API();

        // Load team member
        if (!$team_member = $api->getTeamMember($id)) {
            return Response::notFound();
        }

        // Validate slug
        if ($team_member->slug !== $slug) {
            return Response::redirect('/team/' . $team_member->id . '/' . $team_member->slug);
        }

        // Return view
        return Response::view(
            'team_member',
            [
                'team_member' => $team_member
            ]
        );
    }
);

Router::get(
    '/team/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)',
    function ($size, $id) {

        // Create API
        $api = new \Brew\Team\API();

        // Return photo
        return $api->getPhotoResponse($size, $id);
    }
);

/*
|--------------------------------------------------------------------------
| Contact (Leads)
|--------------------------------------------------------------------------
*/

Router::get(
    '/contact',
    function () {
        return Response::view('contact');
    }
);
