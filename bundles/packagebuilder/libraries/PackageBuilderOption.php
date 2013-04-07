<?php

namespace Brew\PackageBuilder;

use Reinink\Query\Table;

class PackageBuilderOption extends Table
{
    const DB_TABLE = 'package_builder_options';
    protected $id;
    protected $name;
    protected $section;
    protected $small_price_1;
    protected $small_price_2;
    protected $small_description;
    protected $medium_price_1;
    protected $medium_price_2;
    protected $medium_description;
    protected $large_price_1;
    protected $large_price_2;
    protected $large_description;
    protected $display_order;
}
