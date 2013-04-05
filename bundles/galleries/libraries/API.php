<?php
namespace Brew\Galleries;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class API
{
    public function getAllGalleries()
    {
        // Load galleries
        $galleries = DB::rows('galleries::public.galleries.all');

        // Add slug
        foreach ($galleries as $gallery) {
            $gallery->slug = Str::slug($gallery->title);
        }

        return $galleries;
    }

    public function getGallery($id)
    {
        // Load gallery
        if (!$gallery = Gallery::select('id, title, description')->where('id', $id)->row()) {
            Response::notFound();
        }

        // Add slug
        $gallery->slug = Str::slug($gallery->title);

        // Convert markdown description
        $gallery->description = Markdown::defaultTransform(htmlentities($gallery->description));

        return $gallery;
    }

    public function getGalleryPhotos($gallery_id)
    {
        return GalleryPhoto::select('id, caption')
                           ->where('gallery_id', $gallery_id)
                           ->orderBy('display_order')
                           ->rows();
    }

    public function getPhotoResponse($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'galleries/photos/' . $id . '/' . $size . '.jpg');
    }
}
