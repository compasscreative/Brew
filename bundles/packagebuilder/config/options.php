<?php

namespace Brew\PackageBuilder;

use Reinink\Trailmix\Config;

/*
|--------------------------------------------------------------------------
| Sections
|--------------------------------------------------------------------------
*/

Config::set(
    'packagebuilder::sections',
    [
        'Frontyard',
        'Backyard',
    ]
);

/*
|--------------------------------------------------------------------------
| Extras
|--------------------------------------------------------------------------
*/

Config::set(
    'packagebuilder::extras',
    [
        [
            'name' => 'Design',
            'percentage' => 10
        ],
        [
            'name' => 'Preperation',
            'percentage' => 15
        ],
    ]
);
