<?php

	namespace Brew\Bundle\App;

	use Reinink\Routy\Router;
	use Reinink\Reveal\Response;

	Router::get('/', function()
	{
		return Response::view('home');
	});

	Router::get('/contact', function()
	{
		return Response::view('contact');
	});