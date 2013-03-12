Buster
======

## Introduction

Buster is an extremely lightweight class designed to help solve caching annoyances with CSS and JavaScript files. It was inspired by and designed to work with the [HTML5 Boilerplate](http://html5boilerplate.com).

In an effort to make our websites faster, we use far-future expires headers for our CSS and JavaScript files. But what happens when you want to make a change to that file? How do you make sure everyone downloads the newest version? You can rename it, but that's annoying. Another popular trick is to append a query string to the URL:

```html
<link rel="stylesheet" href="/css/style.css?v=1" />
```
However, as Steve Souders [explains](http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring/), query strings can be problematic. A better approach, [found](https://github.com/h5bp/html5-boilerplate/wiki/cachebusting) in the HTML5 Boilerplate, is "filename cache busting". And it's rather simple. Just inject a timestamp at the end of the URL:

```html
<link rel="stylesheet" href="/css/style.1337191200.css" />
```

Then, with some server side help (via `.htaccess`, `web.config` or `nginx.conf`) the URL is automatically converted to `/css/style.css`. Pretty cool eh? Yes, but you still need to update the timestamp each time you change the file! That's where Buster comes in.

## How it works

Buster automatically generates a "cache busted" URL **using the timestamp of your CSS or JavaScript file's last update**. This is done using the [filemtime](http://php.net/manual/en/function.filemtime.php) function.

### Example:

```php
<?php

use Reinink\Buster\Buster;

// Create a cache buster instance
// Set the path where PHP can find the public files
$buster = new Buster('/path/to/public/files');

// Output a link tag
echo $buster->css('/css/style.css');

// Output a script tag
echo $buster->js('/js/script.js');
```

### Example output:
```html
<link rel="stylesheet" href="/css/style.1337191200.css" />
<script src="/js/script.1337191200.js"></script>
```

### Complete example

For a more complete example, see the `example.php` file.

## Setup

Remember, Buster was designed to work with the HTML5 Boilerplate. It needs URL rewriting setup in the server configuration file. For example, here is a snippet from the HTML5 Boilerplate `.htaccess` file:

```apache
<IfModule mod_rewrite.c>
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.+)\.(\d+)\.(js|css|png|jpg|gif)$ $1.$3 [L]
</IfModule>
```

## Questions?

Send me a message on Twitter at [@reinink](https://twitter.com/reinink).