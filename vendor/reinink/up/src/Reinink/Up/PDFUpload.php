<?php
namespace Reinink\Up;

class PDFUpload extends FileUpload
{
    /**
     * Create a new PDFUpload instance.
     *
     * @param  string $file_types
     * @return void
     */
    public function __construct($file_types = array('application/pdf'))
    {
        $this->file_types = $file_types;
    }
}
