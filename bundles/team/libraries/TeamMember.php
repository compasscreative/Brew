<?php
namespace Brew\Team;

use Reinink\Query\Table;

class TeamMember extends Table
{
    const DB_TABLE = 'team_members';
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $title;
    protected $bio;
    protected $email;
    protected $phone;
    protected $display_order;

    public function delete()
    {
        // Set image folder
        $folder = STORAGE_PATH . 'team/photos/' . $this->id . '/';

        // Delete all images
        if (is_file($folder . 'xlarge.jpg')) {
            unlink($folder . 'xlarge.jpg');
        }

        if (is_file($folder . 'large.jpg')) {
            unlink($folder . 'large.jpg');
        }

        if (is_file($folder . 'medium.jpg')) {
            unlink($folder . 'medium.jpg');
        }

        if (is_file($folder . 'small.jpg')) {
            unlink($folder . 'small.jpg');
        }

        if (is_file($folder . 'xsmall.jpg')) {
            unlink($folder . 'xsmall.jpg');
        }

        // Delete the folder
        if (is_dir($folder)) {
            rmdir($folder);
        }

        // Delete from database
        parent::delete();
    }
}
