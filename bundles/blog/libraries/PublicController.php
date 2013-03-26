<?php
namespace Brew\Blog;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class PublicController
{
    public function displayIndex()
    {
        // Load articles
        $articles = DB::rows('blog::public.articles.index');

        // Add article details
        foreach ($articles as $article) {

            // Create intro
            $article->intro = Markdown::defaultTransform(htmlentities(explode('<!--BREAK-->', $article->body)[0]));

            // Set article url
            $article->url = Config::get('blog::base_url') . '/' . $article->id . '/' . Str::slug($article->title);

            // Set photo url
            if ($article->photo_id) {
                $article->photo_url = Config::get('blog::base_url') . '/photo/large/' . $article->photo_id;
            } else {
                $article->photo_url = null;
            }
        }

        // Display page
        return Response::view(
            'blog::index',
            [
                'articles' => $articles,
                'sidebar' => $this->generateSidebar()->render()
            ]
        );
    }

    public function displayBlogArticle($id, $slug)
    {
        // Load article
        if (!$article = BlogArticle::select('id, title, body, published_date')->where('id', $id)->row()) {
            Response::notFound();
        }

        // Validate url slug
        if ($slug !== Str::slug($article->title)) {
            return Response::redirect(Config::get('galleries::base_url') . '/' . $article->id . '/' . Str::slug($article->title));
        }

        // Convert markdown body
        $article->body = Markdown::defaultTransform(htmlentities(str_replace('<!--BREAK-->', '', $article->body)));

        // Load photos
        if ($photos = BlogPhoto::select('id, caption')->where('article_id', $id)->orderBy('display_order')->rows()) {

            foreach ($photos as $photo) {
                $photo->xlarge_url = Config::get('blog::base_url') . '/photo/xlarge/' . $photo->id;
                $photo->large_url = Config::get('blog::base_url') . '/photo/large/' . $photo->id;
                $photo->small_url = Config::get('blog::base_url') . '/photo/small/' . $photo->id;
            }
        }

        // Load categories
        if ($categories = BlogCategory::select('id, name')->orderBy('name')->rows()) {

            foreach ($categories as $category) {
                $category->url = Config::get('blog::base_url') . '/category/' . $category->id . '/' . Str::slug($category->name);
            }
        }

        // Load other articles
        $other_articles = DB::rows('blog::public.articles.sidebar');

        // Add article details
        foreach ($other_articles as $other_article) {

            // Set article url
            $other_article->url = Config::get('blog::base_url') . '/' . $other_article->id . '/' . Str::slug($other_article->title);

            // Set photo url
            if ($other_article->photo_id) {
                $other_article->photo_url = Config::get('blog::base_url') . '/photo/small/' . $other_article->photo_id;
            } else {
                $other_article->photo_url = null;
            }
        }

        // Display page
        return Response::view(
            'blog::article',
            array(
                'article' => $article,
                'photos' => $photos,
                'sidebar' => $this->generateSidebar()->render()
            )
        );
    }

    private function generateSidebar()
    {
        // Load categories
        if ($categories = BlogCategory::select('id, name')->orderBy('name')->rows()) {

            foreach ($categories as $category) {
                $category->url = Config::get('blog::base_url') . '/category/' . $category->id . '/' . Str::slug($category->name);
            }
        }

        // Load other articles
        $other_articles = DB::rows('blog::public.articles.sidebar');

        // Add article details
        foreach ($other_articles as $other_article) {

            // Set article url
            $other_article->url = Config::get('blog::base_url') . '/' . $other_article->id . '/' . Str::slug($other_article->title);

            // Set photo url
            if ($other_article->photo_id) {
                $other_article->photo_url = Config::get('blog::base_url') . '/photo/small/' . $other_article->photo_id;
            } else {
                $other_article->photo_url = null;
            }
        }

        // Display page
        return Response::view(
            'blog::sidebar',
            array(
                'categories' => $categories,
                'other_articles' => $other_articles
            )
        );
    }

    public function displayPhoto($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'blog/photos/' . $id . '/' . $size . '.jpg');
    }

    public function displayCategory($id, $slug)
    {
        // Load category
        if (!$category = BlogCategory::select('id, name')->where('id', $id)->row()) {
            Response::notFound();
        }

        // Validate url slug
        if ($slug !== Str::slug($category->name)) {
            return Response::redirect(Config::get('blog::base_url') . '/category/' . $category->id . '/' . Str::slug($category->name));
        }

        // Load articles
        $articles = DB::rows('blog::public.articles.category', array('category_id' => $id));

        // Add article details
        foreach ($articles as $article) {

            // Set article url
            $article->url = Config::get('blog::base_url') . '/' . $article->id . '/' . Str::slug($article->title);

            // Set photo url
            if ($article->photo_id) {
                $article->photo_url = Config::get('blog::base_url') . '/photo/medium/' . $article->photo_id;
            } else {
                $article->photo_url = null;
            }
        }

        // Display page
        return Response::view(
            'blog::category',
            [
                'category' => $category,
                'articles' => $articles,
                'sidebar' => $this->generateSidebar()->render()
            ]
        );
    }
}
