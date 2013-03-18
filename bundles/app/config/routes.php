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
    '/blog',
    function () {
        return Response::view('blog/index');
    }
);

Router::get(
    '/galleries',
    function () {
        return Response::view('galleries/index');
    }
);

Router::get(
    '/leads',
    function () {
        return Response::view('leads');
    }
);

Router::get(
    '/projects',
    function () {
        return Response::view('projects/index');
    }
);

Router::get(
    '/team',
    function () {
        return Response::view('team/index');
    }
);
