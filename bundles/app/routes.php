<?php

	use Reinink\Reveal\View;
	use Reinink\Routy\Router;

	Router::get('/', function()
	{
		return View::make('home');
	});

	Router::get('/contact', function()
	{
		return View::make('contact');
	});