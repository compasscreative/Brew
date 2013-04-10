<?php

namespace Brew\Blog;

use Reinink\Query\Table;

class BlogCategory extends Table
{
    const DB_TABLE = 'blog_categories';
    protected $id;
    protected $name;
}
