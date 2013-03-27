<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?

        if (isset($this->title)):
            echo $this->title . ' | Brew';
        else:
            echo 'Brew';
        endif;

    ?></title>
    <?
        if (isset($this->description)):
            echo '<meta name="description" content="' . $this->description . '">';
        endif;
    ?>
    <!--[if lt IE 8]><?=Asset::css('/css/basic.css')?><![endif]-->
    <!--[if IE 8]><?=Asset::css('/css/old_ie.css')?><![endif]-->
    <!--[if gt IE 8]><!--><?=Asset::css('/css/all.css')?><!--<![endif]-->
    <?=Asset::js('/vendor/modernizr/modernizr.js')?>
</head>

<body>

<header>
    <a class="logo" href="/">Brew</a>
    <nav>
        <ul>
            <li <?=URI::is('/') ? 'class="selected"' : ''?>><a href="/">Home</a></li>
            <li <?=URI::is('/blog') ? 'class="selected"' : ''?>><a href="/blog">Blog</a></li>
            <li <?=URI::is(Config::get('galleries::base_url')) ? 'class="selected"' : ''?>><a href="<?=Config::get('galleries::base_url')?>">Galleries</a></li>
            <li <?=URI::is(Config::get('projects::base_url')) ? 'class="selected"' : ''?>><a href="<?=Config::get('projects::base_url')?>">Projects</a></li>
            <li <?=URI::is(Config::get('team::base_url')) ? 'class="selected"' : ''?>><a href="<?=Config::get('team::base_url')?>">Team</a></li>
            <li <?=URI::is(Config::get('packagebuilder::base_url')) ? 'class="selected"' : ''?>><a href="<?=Config::get('packagebuilder::base_url')?>">Package Builder</a></li>
            <li <?=URI::is('/contact') ? 'class="selected"' : ''?>><a href="/contact">Contact</a></li>
            <li><a href="/admin"><em>Admin</em></a></li>
        </ul>
    </nav>
</header>