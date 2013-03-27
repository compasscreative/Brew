<?php
namespace Brew\PackageBuilder;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class PublicController
{
    public function displayIndex()
    {
        // Create array to house data
        $sections = [];

        // Add data to array
        foreach (Config::get('packagebuilder::sections') as $name) {

            // Load options
            $options = PackageBuilderOption::select('id, name, small_price_1, small_price_2, small_description, medium_price_1, medium_price_2, medium_description, large_price_1, large_price_2, large_description')
                                           ->where('section', $name)
                                           ->orderBy('display_order')
                                           ->rows();

            // Prepare options for display
            foreach ($options as $option) {

                // Set photo folder
                $folder = STORAGE_PATH . 'packagebuilder/photos/' . $option->id . '/';

                // Check if small photo exists
                if (is_file($folder . 'small_small.jpg')) {
                    $option->small_photo['small'] = Config::get('packagebuilder::base_url') . '/photo/small/small/' . $option->id . '/' . filemtime($folder . 'small_small.jpg');
                    $option->small_photo['large'] = Config::get('packagebuilder::base_url') . '/photo/large/small/' . $option->id . '/' . filemtime($folder . 'small_large.jpg');
                } else {
                    $option->small_photo = null;
                }

                // Check if medium photo exists
                if (is_file($folder . 'medium_small.jpg')) {
                    $option->medium_photo['small'] = Config::get('packagebuilder::base_url') . '/photo/small/medium/' . $option->id . '/' . filemtime($folder . 'medium_small.jpg');
                    $option->medium_photo['large'] = Config::get('packagebuilder::base_url') . '/photo/large/medium/' . $option->id . '/' . filemtime($folder . 'medium_large.jpg');
                } else {
                    $option->medium_photo = null;
                }

                // Check if large photo exists
                if (is_file($folder . 'large_small.jpg')) {
                    $option->large_photo['small'] = Config::get('packagebuilder::base_url') . '/photo/small/large/' . $option->id . '/' . filemtime($folder . 'large_small.jpg');
                    $option->large_photo['large'] = Config::get('packagebuilder::base_url') . '/photo/large/large/' . $option->id . '/' . filemtime($folder . 'large_large.jpg');
                } else {
                    $option->large_photo = null;
                }
            }

            // Add data to array
            if ($options) {
                $sections[] =
                [
                    'name' => $name,
                    'options' => $options
                ];
            }
        }

        return Response::view(
            Config::get('packagebuilder::views')['index'],
            [
                'sections' => $sections,
                'extras' => Config::get('packagebuilder::extras')
            ]
        );
    }

    public function displayPhoto($image_size, $option_size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'packagebuilder/photos/' . $id . '/' . $option_size . '_' . $image_size . '.jpg');
    }
}
