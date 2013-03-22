<?php
namespace Brew\Team;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class PublicController
{
    public function displayIndex()
    {
        // Load galleries
        $galleries = DB::rows('galleries::public.galleries.all');

        // Add urls
        foreach ($galleries as $gallery) {
            $gallery->url = Config::get('team::base_url') . '/' . $gallery->id . '/' . Str::slug($gallery->title);
            $gallery->photo_url = Config::get('team::base_url') . '/photo/medium/' . $gallery->photo_id;
        }

        // Display page
        return Response::view('galleries::index', array('galleries' => $galleries));
    }

    public function displayGallery($id, $slug)
    {
        // Load gallery
        if (!$gallery = Gallery::select('id, title, description')->where('id', $id)->row()) {
            Response::notFound();
        }

        // Validate url slug
        if ($slug !== Str::slug($gallery->title)) {
            return Response::redirect(Config::get('team::base_url') . '/' . $gallery->id . '/' . Str::slug($gallery->title));
        }

        // Convert markdown description
        $gallery->description = Markdown::defaultTransform(htmlentities($gallery->description));

        // Load photos
        if (!$photos = GalleryPhoto::select('id, caption')->where('gallery_id', $id)->orderBy('display_order')->rows()) {
            Response::notFound();
        }

        // Add photo urls
        foreach ($photos as $photo) {
            $photo->xlarge_url = Config::get('team::base_url') . '/photo/xlarge/' . $photo->id;
            $photo->small_url = Config::get('team::base_url') . '/photo/small/' . $photo->id;
        }

        // Load other galleries
        $other_galleries = DB::rows('galleries::public.galleries.all');

        // Add urls
        foreach ($other_galleries as $other_gallery) {
            $other_gallery->url = Config::get('team::base_url') . '/' . $other_gallery->id . '/' . Str::slug($other_gallery->title);
            $other_gallery->photo_url = Config::get('team::base_url') . '/photo/small/' . $other_gallery->photo_id;
        }

        // Display page
        return Response::view(
            'galleries::gallery',
            array(
                'gallery' => $gallery,
                'photos' => $photos,
                'other_galleries' => $other_galleries
            )
        );
    }

    public function displayPhoto($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'team/photos/' . $id . '/' . $size . '.jpg');
    }
}
