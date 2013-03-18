<?php
namespace Brew\Galleries;

use Reinink\Query\Table;

class Gallery extends Table
{
    const DB_TABLE = 'galleries';
    protected $id;
    protected $title;
    protected $description;
    protected $priority;
}
