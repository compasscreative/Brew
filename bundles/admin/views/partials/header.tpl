<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$this->title?> | Admin</title>
    <?=Asset::css('/css/admin.css')?>
</head>
<body>

<div class="container">

    <div class="header">
        <h1><?=Config::get('admin::company')?></h1>
        <ul>
            <?
                if (isset(Config::$values['admin::menu'])):

                    // Sort the array by name
                    usort(Config::$values['admin::menu'], function($a, $b) {
                        return strnatcasecmp($a['name'], $b['name']);
                    });

                    // Display each menu item
                    foreach (Config::get('admin::menu') as $item):
                        echo (strpos($_SERVER['REQUEST_URI'], $item['url']) === 0) ? '<li class="selected">' : '<li>';
                        echo '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';
                        echo '</li>';
                    endforeach;

                endif;
            ?>
            <li><a href="/">Visit Website</a></li>
            <li><a href="/admin/logout">Logout</a></li>
        </ul>
    </div>
