<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?

        if (isset($this->title)):
            echo $e($this->title) . ' | Brew';
        else:
            echo 'Brew';
        endif;

    ?></title>
    <?
        if (isset($this->description)):
            echo '<meta name="description" content="' . $e($this->description) . '">';
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
            <li <?=URI::is('/galleries') ? 'class="selected"' : ''?>><a href="/galleries">Galleries</a></li>
            <li <?=URI::is('/projects') ? 'class="selected"' : ''?>><a href="/projects">Projects</a></li>
            <li <?=URI::is('/team') ? 'class="selected"' : ''?>><a href="/team">Team</a></li>
            <li <?=URI::is('/contact') ? 'class="selected"' : ''?>><a href="/contact">Contact</a></li>
            <li><a href="/admin"><em>Admin</em></a></li>
        </ul>
    </nav>
</header>