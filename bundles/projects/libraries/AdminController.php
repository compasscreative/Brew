<?php
namespace Brew\Projects;

use Brew\Admin\SecureController;
use Reinink\Trailmix\Config;
use Reinink\Magick\Magick;
use Reinink\Reveal\Response;
use Reinink\Up\ImageUpload;

class AdminController extends SecureController
{
    public function displayProjects()
    {
        $projects = Project::select('id, title, completed_date, show_lo_award, (SELECT COUNT(*) FROM project_photos WHERE project_id = projects.id) AS photos')
                           ->orderBy('completed_date DESC')
                           ->rows();

        return Response::view('projects::admin/index', array('projects' => $projects));
    }

    public function addProject()
    {
        return Response::view('projects::admin/add');
    }

    public function editProject($id)
    {
        if (!$project = Project::select('id, title, introduction, description, awards, show_lo_award, completed_date')
                               ->where('id', $id)
                               ->row()) {

            Response::notFound();
        }

        $photos = ProjectPhoto::select('id, section, caption')
                              ->where('project_id', $project->id)
                              ->orderBy('display_order')
                              ->rows();

        return Response::view('projects::admin/edit', array('project' => $project, 'photos' => $photos));
    }

    public function insertProject()
    {
        // Check for required paramaters
        if (!isset($_POST['title']) or
            !isset($_POST['introduction']) or
            !isset($_POST['description']) or
            !isset($_POST['awards']) or
            !isset($_POST['show_lo_award']) or
            !isset($_POST['completed_date'])) {

            Response::badRequest();
        }

        // Create the project
        $project = new Project();
        $project->title = trim($_POST['title']);
        $project->introduction = trim($_POST['introduction']);
        $project->description = trim($_POST['description']);
        $project->awards = trim($_POST['awards']);
        $project->show_lo_award = trim($_POST['show_lo_award']);
        $project->completed_date = trim($_POST['completed_date']);
        $project->insert();

        // Return new id
        return Response::json(array('id' => $project->id));
    }

    public function updateProject()
    {
        // Check for required paramaters
        if (!isset($_POST['id']) or
            !isset($_POST['title']) or
            !isset($_POST['introduction']) or
            !isset($_POST['description']) or
            !isset($_POST['awards']) or
            !isset($_POST['show_lo_award']) or
            !isset($_POST['completed_date'])) {

            Response::badRequest();
        }

        // Load the project
        if (!$project = Project::select($_POST['id'])) {
            Response::notFound();
        }

        // Update the project
        $project->id = trim($_POST['id']);
        $project->title = trim($_POST['title']);
        $project->introduction = trim($_POST['introduction']);
        $project->description = trim($_POST['description']);
        $project->awards = trim($_POST['awards']);
        $project->show_lo_award = trim($_POST['show_lo_award']);
        $project->completed_date = trim($_POST['completed_date']);
        $project->update();

        // Update photo order and captions
        if (isset($_POST['photos'])) {

            $display_order = 1;

            foreach ($_POST['photos'] as $type) {

                if (isset($type['seperator'])) {

                    $section = $type['seperator'];

                } elseif (isset($type['photo'])) {

                    // Get photo id and caption
                    $id = key($type['photo']);
                    $caption = $type['photo'][$id];

                    // Load the photo
                    if ($photo = ProjectPhoto::select($id)) {

                        // Update object
                        $photo->caption = trim($caption);
                        $photo->section = $section;
                        $photo->display_order = $display_order;
                        $photo->update();

                        // Update display order
                        $display_order++;
                    }
                }
            }
        }

        // Success
        return true;
    }

    public function deleteProject()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the project
        if (!$project = Project::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete all project photos
        foreach (ProjectPhoto::select()
                             ->where('project_id', $project->id)
                             ->rows() as $photo) {

            $photo->delete();
        }

        // Delete the project
        $project->delete();

        // Success
        return true;
    }

    public function insertPhoto()
    {
        // Check for project id
        if (!isset($_POST['project_id'])) {
            Response::badRequest();
        }

        // Load project from database
        if (!$project = Project::select($_POST['project_id'])) {
            Response::notFound();
        }

        // Create an image upload handler
        $upload = new ImageUpload(new Magick(Config::get('imagemagick')));

        // Validate uploaded file
        if (!$upload->validate('image')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => $upload->error
                )
            );
        }

        // Create new database record
        $project_photo = new ProjectPhoto();
        $project_photo->project_id = $project->id;
        $project_photo->section = 'Finished';
        $project_photo->display_order = ProjectPhoto::select('COUNT(*)+1')
                                                    ->where('project_id', $project->id)
                                                    ->field();
        $project_photo->insert();

        // Set project photo folder path
        $folder = STORAGE_PATH . 'projects/photos/' . $project_photo->id . '/';

        // Create new folder
        mkdir($folder);

        // Create various sizes
        $im = new Magick(Config::get('imagemagick'));
        $im->setFilePath($upload->file_path);

        // Xlarge
        if (!$im->setHeight(1200)
                ->convert($folder . 'xlarge.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create xlarge image.'
                )
            );
        }

        // Large
        if (!$im->setCropByRatio(1175/660)
                ->setHeight(null)
                ->setWidth(1175)
                ->convert($folder . 'large.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create large image.'
                )
            );
        }

        // Medium
        if (!$im->setCropByRatio(750/500)
                ->setWidth(750)
                ->convert($folder . 'medium.jpg')) {
            return Response::json(
                array(
                    'success' => false,
                    'reason' => 'Unable to create medium image.'
                )
            );
        }

        // Small
        if (!$im->setCropByRatio(250/160)
                ->setWidth(250)
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
                'id' => $project_photo->id
            )
        );
    }

    public function deletePhoto()
    {
        // Check for required paramaters
        if (!isset($_POST['id'])) {
            Response::badRequest();
        }

        // Load the photo
        if (!$photo = ProjectPhoto::select($_POST['id'])) {
            Response::notFound();
        }

        // Delete the photo
        $photo->delete();

        // Reorder existing photos
        foreach (ProjectPhoto::select()
                             ->where('project_id', $photo->project_id)
                             ->orderBy('display_order')
                             ->rows() as $key => $photo) {

            $photo->display_order = $key + 1;
            $photo->update();
        }

        // Success
        return true;
    }
}
