<?php

namespace Brew\Products;

use Reinink\Query\Table;

class Product extends Table
{
    const DB_TABLE = 'products';
    protected $id;
    protected $title;
    protected $introduction;
    protected $description;
    protected $title_tag;
    protected $description_tag;
    protected $display_order;
    protected $slug;
}
