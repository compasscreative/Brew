<?php
namespace Reinink\Up;

class FileUpload
{
    /**
     * The allowed file types.
     *
     * @var array
     */
    public $file_types;

    /**
     * The uploaded file path.
     *
     * @var string
     */
    public $file_path;

    /**
     * The uploaded file name.
     *
     * @var string
     */
    public $file_name;

    /**
     * The error if validation fails.
     *
     * @var string
     */
    public $error;

    /**
     * Create a new FileUpload instance.
     *
     * @param  string $file_types
     * @return void
     */
    public function __construct($file_types = null)
    {
        $this->file_types = $file_types;
    }

    /**
     * Validate the uploaded file.
     *
     * @param  string $upload_name
     * @return bool
     */
    public function validate($upload_name)
    {
        // Check if upload variable exists
        if (!isset($_FILES[$upload_name])) {

            $this->error = 'File upload (' . $upload_name . ') not found.';

            return false;
        }

        // Verify this is a multipart request
        if (!isset($_SERVER['CONTENT_TYPE']) or strpos(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/') !== 0) {

            $this->error = 'Not a valid multipart request.';

            return false;
        }

        // Verify this is an uploaded file (security)
        if (!is_uploaded_file($_FILES[$upload_name]['tmp_name'])) {

            $this->error = 'Possible file upload attack!';

            return false;
        }

        // Validate file size
        if ($_FILES[$upload_name]['size'] == 0) {
            $this->error = 'The file is empty.';

            return false;
        }

        // Validate file type
        if (is_array($this->file_types)) {

            // Get mime type from operating system
            $type = exec('file -b --mime-type ' . $_FILES[$upload_name]['tmp_name']);

            // Validate file type
            if (empty($type) or !in_array($type, $this->file_types)) {

                $this->error = 'Invalid file type.';

                return false;
            }
        }

        // Update object
        $this->file_path = $_FILES[$upload_name]['tmp_name'];
        $this->file_name = $_FILES[$upload_name]['name'];

        return true;
    }

    /**
     * Save uploaded file to destination. Always validate first.
     *
     * @param  string $upload_name
     * @return bool
     */
    public function save($dest_path)
    {
        // Check if file path has been set
        if (!isset($this->file_path)) {

            $this->error = 'File path not set, validate first.';

            return false;
        }

        // Check that the file exists
        if (!is_file($this->file_path)) {

            $this->error = 'File does not exist.';

            return false;
        }

        // Get path info
        $path = pathinfo($dest_path);

        // Create folder if it doesn't exist
        if (!is_dir($path['dirname'])) {
            if (!@mkdir($path['dirname'])) {

                $this->error = 'Unable to create directory.';

                return false;
            }
        }

        // Move file to folder
        if (@rename($this->file_path, $dest_path)) {

            return true;

        } else {

            $this->error = 'Unable to save file.';

            return false;
        }
    }
}
