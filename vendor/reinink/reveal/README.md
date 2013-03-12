Reveal
======

## Responses

### Setup

Simply tell `Response::get` to handle whatever your router returns. For example:

```php
<?php

	Response::get(Router::run())->send();
```

### 404 pages

Maybe you have a fancy `404` page you'd like to show? You can do that, here is an example how. Note, this will handle all error responses, including bad requests (`400`), unauthorized requests (`401`), rorbidden requests (`403`), pages not found (`404`) and internal server errors (`500`).

```php
<?php

	$response = Response::get(Router::run());

	if ($response instanceof ErrorResponse)
	{
		$response->content = Response::view('error.php', array('code' => $response->code, 'message' => $response->message))->render();
	}

	$response->send();
```

You can trigger a `404` within your application by simply returning nothing, returning false, or returing an actual error response. All can be helpful.

```php
<?php

	// 404 page
	public function display_profile($person_id)
	{
		if (!$person = Person::select($person_id))
		{
			return false;
		}

		return Response::view('profile.php', array
		(
			'person' => $person
		));
	}

	// 404 page (no response)
	public function display_profile($person_id)
	{
		if ($person = Person::select($person_id))
		{
			return Response::view('profile.php', array
			(
				'person' => $person
			));
		}
	}

	// 404 page (with message)
	public function display_profile($person_id)
	{
		if (!$person = Person::select($person_id))
		{
			return Response::not_found('Person with the id ' . $person_id . ' does not exist.');
		}

		return Response::view('profile.php', array
		(
			'person' => $person
		));
	}
```

## Views

### Creating views

```php
<?php

	return Response::view('home.php');
```

### Adding data to views

```php
<?php

	return Response::view('home.php', array
	(
		'name' => 'Jonathan',
		'country' = 'Canada'
	));
```

## Errors

```php
<?php

	// 400
	return Response::bad_request();

	// 401
	return Response::unauthorized();

	// 403
	return Response::forbidden();

	// 404
	return Response::not_found();

	// 500
	return Response::server_error();
```

## Redirects

```php
<?php

	// Standard 301 redirect
	return Response::redirect('/url');

	// Redirecting with a specific code
	return Response::redirect('/url', 301);
```

## JSON

```php
<?php

	// JSON encode array
	return Response::json($array);
```

## Files

Outputting files couldn't be easier, just return the path to your image or document. If the file doesn't exist, a `404` `ErrorResponse` will automatically be returned instead.

```php
<?php

	// Display an image
	return Response::jpg($file_path);

	// Display a PDF document
	return Response::pdf($file_path);

	// Force download a PDF document
	return Response::pdf($file_path, 'document.pdf', true);
```

## Strings

Strings are automatically converted into a valid `Response` object.

```php
<?php

	// This...
	return 'String';

	// ...is the same as this:
	return new Response('String');
```

## Blank pages

Sometimes there just isn't anything to say, but a valid response is still required. Just `return false` to prevent a `404` `ErrorResponse`.

```php
<?php

	// Blank page
	return true;
```