<?php
use Reinink\Buster\Buster;
use Reinink\Routy\URI;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?=$this->title?></title>
    <?php if (isset($this->description)) echo '<meta name="description" content="' . $this->description . '">'; ?>
    <?php $this->buster = new Buster(PUBLIC_PATH); ?>
    <!--[if lt IE 8]><?=$this->buster->css('/css/basic.css')?><![endif]-->
    <!--[if IE 8]><?=$this->buster->css('/css/old_ie.css')?><![endif]-->
    <!--[if gt IE 8]><!--><?=$this->buster->css('/css/all.css')?><!--<![endif]-->
    <?=$this->buster->js('/vendor/modernizr/modernizr.js')?>
</head>

<body>

<header>
    <a class="logo" href="/">Brew</a>
    <nav>
        <ul>
            <li <?=URI::is('/') ? 'class="selected"' : ''?>><a href="/">Home</a></li>
            <li <?=URI::is('/blog') ? 'class="selected"' : ''?>><a href="/blog">Blog</a></li>
            <li <?=URI::is('/galleries') ? 'class="selected"' : ''?>><a href="/galleries">Galleries</a></li>
            <li <?=URI::is('/leads') ? 'class="selected"' : ''?>><a href="/leads">Leads</a></li>
            <li <?=URI::is('/projects') ? 'class="selected"' : ''?>><a href="/projects">Projects</a></li>
            <li <?=URI::is('/team') ? 'class="selected"' : ''?>><a href="/team">Team</a></li>
            <li <?=URI::is('/admin') ? 'class="selected"' : ''?>><a href="/admin">Admin</a></li>
        </ul>
    </nav>
</header>
