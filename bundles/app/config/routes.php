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
| Blog
|--------------------------------------------------------------------------
*/

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
    '/blog/image/([0-9]+)/([a-z-0-9]+)',
    function ($id, $filename) {

        // Create API
        $api = new \Brew\Blog\API();

        // Return photo
        return $api->getImageResponse($id, $filename);
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
            'galleries/galleries',
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
            'galleries/gallery',
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
| Package Builder
|--------------------------------------------------------------------------
*/

Router::get(
    '/package-builder',
    function () {

        // Create API
        $api = new \Brew\PackageBuilder\API();

        // Get form
        $form = $api->getForm('/package-builder');

        // Return view
        return Response::view(
            'package_builder/package_builder',
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

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

Router::get(
    '/products',
    function () {

        // Create API
        $api = new \Brew\Products\API();

        // Load all products
        $products = $api->getAllProducts();

        // Return view
        return Response::view(
            'products/products',
            [
                'products' => $products
            ]
        );
    }
);

Router::get(
    '/products/([0-9]+)/([a-z-0-9]+)',
    function ($id, $slug) {

        // Create API
        $api = new \Brew\Products\API();

        // Load product
        if (!$product = $api->getProduct($id)) {
            return Response::notFound();
        }

        // Validate slug
        if ($product->slug !== $slug) {
            return Response::redirect('/products/' . $product->id . '/' . $product->slug);
        }

        // Load photos
        if (!$photos = $api->getProductPhotos($product->id)) {
            return Response::notFound();
        }

        // Load all products
        $products = $api->getAllProducts();

        // Return view
        return Response::view(
            'products/product',
            [
                'product' => $product,
                'photos' => $photos,
                'products' => $products
            ]
        );
    }
);

Router::get(
    '/products/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)',
    function ($size, $id) {

        // Create API
        $api = new \Brew\Products\API();

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

        // Load team members by category
        $categories = $api->getTeamMembersByCategory();

        // Return view
        return Response::view(
            'team/team',
            [
                'categories' => $categories
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
            'team/team_member',
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
