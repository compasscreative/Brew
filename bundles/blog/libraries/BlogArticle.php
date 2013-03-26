<?php
namespace Brew\Blog;

use Reinink\Query\Table;

class BlogArticle extends Table
{
    const DB_TABLE = 'blog_articles';
    protected $id;
    protected $category_id;
    protected $title;
    protected $body;
    protected $status;
    protected $published_date;
}
