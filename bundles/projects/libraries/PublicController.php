<?php
namespace Brew\Projects;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class PublicController
{
    public function displayIndex()
    {
        // Load projects
        $projects = DB::rows('projects::public.projects.all');

        // Add urls
        foreach ($projects as $project) {
            $project->url = Config::get('projects::base_url') . '/' . $project->id . '/' . Str::slug($project->title);
            $project->photo_url = Config::get('projects::base_url') . '/photo/medium/' . $project->photo_id;
        }

        // Display page
        return Response::view('projects::index', array('projects' => $projects));
    }

    public function displayProject($id, $slug)
    {
        // Load project
        if (!$project = Project::select('id, title, description, completed_date')->where('id', $id)->row()) {
            Response::notFound();
        }

        // Validate url slug
        if ($slug !== Str::slug($project->title)) {
            return Response::redirect(Config::get('projects::base_url') . '/' . $project->id . '/' . Str::slug($project->title));
        }

        // Convert markdown description
        $project->description = Markdown::defaultTransform(htmlentities($project->description));

        // Load photos
        if (!$photos = ProjectPhoto::select('id, caption')->where('project_id', $id)->orderBy('display_order')->rows()) {
            Response::notFound();
        }

        // Add photo urls
        foreach ($photos as $photo) {
            $photo->xlarge_url = Config::get('projects::base_url') . '/photo/xlarge/' . $photo->id;
            $photo->small_url = Config::get('projects::base_url') . '/photo/small/' . $photo->id;
        }

        // Display page
        return Response::view(
            'projects::project',
            array(
                'project' => $project,
                'photos' => $photos
            )
        );
    }

    public function displayPhoto($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'projects/photos/' . $id . '/' . $size . '.jpg');
    }
}
