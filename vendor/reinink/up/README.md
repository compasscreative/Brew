Up
==

## Upload a file

```php
<?php

use Reinink\Up\FileUpload;

// Create an file uploader
$upload = new FileUpload();

// Validate uploaded file
// "file" if the post filename
if (!$upload->validate('file'))
{
	// Do something with $upload->error
}

// Save the file
$upload->save('destination.ext');
```

## Upload a PDF document

```php
<?php

use Reinink\Up\PDFUpload;

// Create an PDF uploader
$upload = new PDFUpload();

// Validate uploaded file
// "pdf" if the post filename
if (!$upload->validate('pdf'))
{
	// Do something with $upload->error
}

// Save the file
$upload->save('destination.pdf');
```

## Upload an image

The `ImageUpload` class uses [ImageMagick](http://www.imagemagick.org/) for validation. Simply include an instance of the [Magick](https://github.com/reinink/Magick) class.

```php
<?php

use Reinink\Magick\Magick;
use Reinink\Up\ImageUpload;

// Create an image uploader (requires Magick class)
$upload = new ImageUpload(new Magick);

// Validate uploaded file
// "image" if the post filename
if (!$upload->validate('image'))
{
	// Do something with $upload->error
}

// Save the file
$upload->save('destination.jpg');
```