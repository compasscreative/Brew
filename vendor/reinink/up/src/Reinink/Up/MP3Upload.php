<?php
namespace Reinink\Up;

class MP3Upload extends FileUpload
{
    /**
     * Create a new MP3Upload instance.
     *
     * @param  string $file_types
     * @return void
     */
    public function __construct($file_types = array('audio/mpeg'))
    {
        $this->file_types = $file_types;
    }
}
