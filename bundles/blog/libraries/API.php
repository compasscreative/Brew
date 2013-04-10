<?php

namespace Brew\Blog;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class API
{
    public function getIndexArticles()
    {
        // Load articles
        $articles = DB::rows('blog::public.articles.index');

        // Add article details
        foreach ($articles as $article) {

            // Set intro and photo
            if ($article->type === 'Markdown') {
                $article->intro = Markdown::defaultTransform(htmlentities(explode('<!--BREAK-->', $article->body)[0]));
            } else {
                $article->intro = explode('<!--BREAK-->', $article->body)[0];
                $article->photo_id = null;
                $article->photo_caption = null;
            }

            // Set slug
            $article->slug = Str::slug($article->title);
        }

        return $articles;
    }

    public function getSidebarArticles()
    {
        // Load articles
        $articles = DB::rows('blog::public.articles.sidebar');

        // Set slug
        foreach ($articles as $article) {
            $article->slug = Str::slug($article->title);
        }

        return $articles;
    }

    public function getCategories()
    {
        // Load categories
        $categories = BlogCategory::select('id, name')->orderBy('name')->rows();

        // Add slug
        foreach ($categories as $category) {
            $category->slug = Str::slug($category->name);
        }

        return $categories;
    }

    public function getArticle($id)
    {
        // Load article
        if (!$article = BlogArticle::select('id, type, title, body, status, published_date')->where('id', $id)->row()) {
            return false;
        }

        // Add slug
        $article->slug = Str::slug($article->title);

        // Convert markdown body
        if ($article->type === 'Markdown') {
            $article->body = Markdown::defaultTransform(htmlentities(str_replace('<!--BREAK-->', '', $article->body)));
        } else {
            $article->body = str_replace('<!--BREAK-->', '', $article->body);
        }

        // Load photos
        if ($article->type === 'Markdown') {
            $article->photos = BlogPhoto::select('id, caption')->where('article_id', $id)->orderBy('display_order')->rows();
        } else {
            $article->photos = array();
        }

        return $article;
    }

    public function getCategory($id, $slug)
    {
        // Load category
        if (!$category = BlogCategory::select('id, name')->where('id', $id)->row()) {
            return false;
        }

        // Add slug
        $category->slug = Str::slug($category->name);

        // Load articles
        $category->articles = DB::rows('blog::public.articles.category', array('category_id' => $id));

        // Add article slugs
        foreach ($category->articles as $article) {
            $article->slug = Str::slug($article->title);
        }

        return $category;
    }

    public function getSearchResults($query)
    {
        // Create search object
        $search = (object) null;
        $search->query = trim($query);

        // Load articles
        $search->articles = DB::rows('blog::public.articles.search', array('query' => '%' . $search->query . '%'));

        // Add article slugs
        foreach ($search->articles as $article) {
            $article->slug = Str::slug($article->title);
        }

        return $search;
    }

    public function getPhotoResponse($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'blog/photos/' . $id . '/' . $size . '.jpg');
    }

    public function getImageResponse($id, $filename)
    {
        return Response::jpg(STORAGE_PATH . 'blog/images/' . $id . '/' . $filename . '.jpg');
    }
}
