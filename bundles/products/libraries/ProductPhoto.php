<?php

namespace Brew\Products;

use Reinink\Query\Table;

class ProductPhoto extends Table
{
    const DB_TABLE = 'product_photos';
    protected $id;
    protected $product_id;
    protected $caption;
    protected $display_order;
}
