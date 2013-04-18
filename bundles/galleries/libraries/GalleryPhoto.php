<?php

namespace Brew\Galleries;

use Reinink\Query\Table;

class GalleryPhoto extends Table
{
    const DB_TABLE = 'gallery_photos';
    protected $id;
    protected $gallery_id;
    protected $caption;
    protected $display_order;
}
