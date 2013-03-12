Routy
======

## Setup

Add the following code to your `.htaccess` file:

```apache
<IfModule mod_rewrite.c>
  DirectorySlash Off
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1
</IfModule>
```

## Basic routes

```php
<?php

// Home page
Router::get('/', function()
{
	// do something
});

// Contact page
Router::get('/contact', function()
{
	// do something
});

// Process form post
Router::post('/form-submit', function()
{
	// do something
});
```

## More complicated routes

```php
<?php

// User profile
Router::get('/user/([0-9]+)', function($user_id)
{
	// do something with $user_id
});

// Output image
Router::get('/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)', function($image_size, $image_id)
{
	// do something with $image_size and $image_id
});
```

## Working with controller classes

```php
<?php

// Home page
Router::get('/', 'Controller::index');

// Contact page
Router::get('/contact', 'Controller::contact');

// Process form post
Router::post('/form-submit', 'Controller::process_form');
```

## Checking the current route

```php
<?php

	// Check if home page
	if (URI::is('/'))
	{
		// do something
	}

	// Check if contact page
	if (URI::is('/contact'))
	{
		// do something
	}

	// Check if in the products section
	// Examples:	/products
	//				/products/product-name
	if (URI::is('/products(/[a-z-]*)?'))
	{
		// do something
	}
```

## Segments

```php
<?php

	// Get all the current segements as an array
	$segments = URI::segments();

	// Get a specific segement
	$segment = URI::segment(1);

	// Check if in the products section
	// Examples:	/products
	//				/products/product-name
	if (URI::segment(1) === 'products')
	{
		// do something
	}
```

## Other checks
```php
<?php

	// Check if the request is secure (HTTPS)
	if (Request::secure())
	{
		// do something
	}

	// Check if the request is an AJAX call
	if (Request::ajax())
	{
		// do something
	}
```