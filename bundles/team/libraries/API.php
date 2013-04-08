<?php
namespace Brew\Team;

use Michelf\Markdown;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class API
{
    public function getCategories()
    {
        return array_merge(array(''), Config::get('team::categories'));
    }

    public function getAllTeamMembers()
    {
        // Load team members
        $team_members = TeamMember::select('id, first_name, last_name, title, category')->orderBy('display_order')->rows();

        // Add details
        foreach ($team_members as $team_member) {

            // Add slug
            $team_member->slug = Str::slug($team_member->first_name . ' ' . $team_member->last_name);

            // Add photo status
            $team_member->has_photo = is_file(STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg');

            // Validate category
            if (!in_array($team_member->category, $this->getCategories())) {
                $team_member->category = '';
            }
        }

        return $team_members;
    }

    public function getTeamMember($id)
    {
        // Load team member
        if (!$team_member = TeamMember::select('id, first_name, last_name, title, bio, email, phone')->where('id', $id)->row()) {
            return false;
        }

        // Add slug
        $team_member->slug = Str::slug($team_member->first_name . ' ' . $team_member->last_name);

        // Add photo status
        $team_member->has_photo = is_file(STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg');

        // Convert markdown bio
        $team_member->bio = Markdown::defaultTransform(htmlentities($team_member->bio));

        return $team_member;
    }

    public function getPhotoResponse($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'team/photos/' . $id . '/' . $size . '.jpg');
    }
}
