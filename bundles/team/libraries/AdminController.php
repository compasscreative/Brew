<?php
namespace Brew\Team;

use Brew\Admin\SecureController;
use Reinink\Magick\Magick;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Asset;
use Reinink\Trailmix\Config;
use Reinink\Up\ImageUpload;

class AdminController extends SecureController
{
    public function displayTeamMembers()
    {
        // Create array of categories
        $categories = array_merge(array(''), Config::get('team::categories'));

        // Load team members
        $members = TeamMember::select('id, first_name, last_name, category')->orderBy('display_order')->rows();

        // Set photo url
        foreach ($members as $team_member) {

            // Set photo path
            $path = STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg';

            // Check if photo exists
            if (is_file($path)) {
                $team_member->photo_url = '/admin/team/photo/small/' . $team_member->id . '/' . filemtime($path);
            } else {
                $team_member->photo_url = null;
            }

            // Validate category
            if (!in_array($team_member->category, $categories)) {
                $team_member->category = '';
            }
        }

        return Response::view(
            'team::admin/index',
            [
                'categories' => $categories,
                'members' => $members
            ]
        );
    }

    public function addTeamMember()
    {
        return Response::view(
            'team::admin/add',
            [
                'categories' => Config::get('team::categories')
            ]
        );
    }

    public function editTeamMember($id)
    {
        if ($team_member = TeamMember::select('id, first_name, last_name, title, bio, email, phone, category')
                              ->where('id', $id)
                              ->row()) {

            // Set photo path
            $path = STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg';

            // Check if photo exists
            if (is_file($path)) {
                $team_member->photo_url = '/admin/team/photo/medium/' . $team_member->id . '/' . filemtime($path);
            } else {
                $team_member->photo_url = null;
            }

            // Display page
            return Response::view(
                'team::admin/edit',
                [
                    'team_member' => $team_member,
                    'categories' => Config::get('team::categories')
                ]
            );
        }
    }

    public function insertTeamMember()
    {
        // Check for required paramaters
        if (!isset($_POST['first_name']) or
            !isset($_POST['last_name']) or
            !isset($_POST['title']) or
            !isset($_POST['bio']) or
            !isset($_POST['email']) or
            !isset($_POST['phone']) or
            !isset($_POST['category'])) {

            Response::badRequest();
        }

        // Create the team member
        $team_member = new TeamMember();
        $team_member->first_name = trim($_POST['first_name']);
        $team_member->last_name = trim($_POST['last_name']);
        $team_member->title = trim($_POST['title']);
        $team_member->bio = trim($_POST['bio']);
        $team_member->email = trim($_POST['email']);
        $team_member->phone = trim($_POST['phone']);
        $team_member->category = trim($_POST['category']);
        $team_member->display_order = TeamMember::select('COUNT(*)+1')->field();
        $team_member->insert();

        // Return new id
        return Response::json(array('id' => $team_member->id));
    }

    public function updateTeamMember()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['first_name']) or
            !isset($_POST['last_name']) or
            !isset($_POST['title']) or
            !isset($_POST['bio']) or
            !isset($_POST['email']) or
            !isset($_POST['phone']) or
            !isset($_POST['category'])) {

            Response::badRequest();
        }

        // Load the team member
        if (!$team_member = TeamMember::select($_POST['id'])) {
            Response::notFound();
        }

        // Update the team member
        $team_member->first_name = trim($_POST['first_name']);
        $team_member->last_name = trim($_POST['last_name']);
        $team_member->title = trim($_POST['title']);
        $team_member->bio = trim($_POST['bio']);
        $team_member->email = trim($_POST['email']);
        $team_member->phone = trim($_POST['phone']);
        $team_member->category = trim($_POST['category']);
        $team_member->update();

        // Success
        return true;
    }

    public function updateTeamMemberOrder()
    {
        // Check for required paramaters
        if (!isset($_POST['category']) or
            !isset($_POST['members'])) {

            Response::badRequest();
        }

        // Load and update each team member
        foreach (explode(',', $_POST['members']) as $display_order => $id) {
            if ($team_member = TeamMember::select($id)) {
                $team_member->category = $_POST['category'];
                $team_member->display_order = $display_order + 1;
                $team_member->update();
            }
        }

        return true;
    }

    public function deleteTeamMember()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the team member
        if (!$team_member = TeamMember::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete the team member
        $team_member->delete();

        // Reorder remaining team member
        foreach (TeamMember::select()
                           ->orderBy('display_order')
                           ->rows() as $key => $photo) {

            $photo->display_order = $key + 1;
            $photo->update();
        }

        // Success
        return true;
    }

    public function displayPhoto($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'team/photos/' . $id . '/' . $size . '.jpg');
    }

    public function insertPhoto()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load team member database
        if (!$team_member = TeamMember::select($_POST['id'])) {
            Response::notFound();
        }

        // Create an Magick image editor
        $im = new Magick(Config::get('imagemagick'));

        // Create an image upload handler
        $upload = new ImageUpload($im);

        // Validate uploaded file
        if (!$upload->validate('image')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => $upload->error
                )
            );
        }

        // Set photo path
        $folder = STORAGE_PATH . 'team/photos/' . $team_member->id . '/';

        // Create new folder
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        // Xlarge
        if (!$im->setCropByRatio(8/10)
                ->setHeight(1000)
                ->convert($folder . 'xlarge.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create xlarge image.'
                )
            );
        }

        // Large
        if (!$im->setHeight(700)
                ->convert($folder . 'large.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create large image.'
                )
            );
        }

        // Medium
        if (!$im->setHeight(500)
                ->convert($folder . 'medium.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create medium image.'
                )
            );
        }

        // Small
        if (!$im->setHeight(250)
                ->convert($folder . 'small.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create small image.'
                )
            );
        }

        // Xsmall
        if (!$im->setCropByRatio(1)
                ->setWidth(75)
                ->convert($folder . 'xsmall.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create xsmall image.'
                )
            );
        }

        // Return success
        return Response::json(
            array(
                'success' => true,
                'url' => '/admin/team/photo/medium/' . $team_member->id . '/' . filemtime($folder . 'medium.jpg')
            )
        );
    }
}
