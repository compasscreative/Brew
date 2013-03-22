<?php
namespace Brew\Team;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class PublicController
{
    public function displayIndex()
    {
        // Load team members
        $team_members = TeamMember::select('id, first_name, last_name')->orderBy('display_order')->rows();

        // Add urls
        foreach ($team_members as $team_member) {

            // Page url
            $team_member->page_url = Config::get('team::base_url') . '/' . $team_member->id . '/' . Str::slug($team_member->first_name . ' ' . $team_member->last_name);

            // Set photo path
            $path = STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg';

            // Check if photo exists
            if (is_file($path)) {
                $team_member->photo_url = Config::get('team::base_url') . '/photo/small/' . $team_member->id . '/' . filemtime($path);
            } else {
                $team_member->photo_url = null;
            }
        }

        return Response::view(Config::get('team::index_view'), array('team_members' => $team_members));
    }

    public function displayTeamMember($id, $slug)
    {
        // Load team member
        if (!$team_member = TeamMember::select('id, first_name, last_name, title, bio, email, phone')->where('id', $id)->row()) {
            Response::notFound();
        }

        // Validate url slug
        if ($slug !== Str::slug($team_member->first_name . ' ' . $team_member->last_name)) {
            return Response::redirect(Config::get('team::base_url') . '/' . $team_member->id . '/' . Str::slug($team_member->first_name . ' ' . $team_member->last_name));
        }

        // Convert markdown bio
        $team_member->bio = Markdown::defaultTransform(htmlentities($team_member->bio));

        // Set photo path
        $path = STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg';

        // Check if photo exists
        if (is_file($path)) {
            $team_member->photo_url = Config::get('team::base_url') . '/photo/medium/' . $team_member->id . '/' . filemtime($path);
        } else {
            $team_member->photo_url = null;
        }

        // Display page
        return Response::view(Config::get('team::profile_view'), array('team_member' => $team_member));
    }

    public function displayPhoto($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'team/photos/' . $id . '/' . $size . '.jpg');
    }
}
