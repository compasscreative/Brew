<?php

namespace Brew\Team;

use Michelf\Markdown;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Config;
use Reinink\Trailmix\Str;

class API
{
    public function getTeamMembers()
    {
        // Load team members
        $team_members = TeamMember::select('id, first_name, last_name, title, category, slug')->orderBy('display_order')->rows();

        // Add details
        foreach ($team_members as $team_member) {

            // Add photo status
            $team_member->has_photo = is_file(STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg');

            // Validate category
            if (!in_array($team_member->category, Config::get('team::categories'))) {
                $team_member->category = '';
            }
        }

        return $team_members;
    }

    public function getTeamMembersByCategory()
    {
        // Create array to house categories
        $categories = [];

        // Load team members
        $members = $this->getTeamMembers();

        foreach (Config::get('team::categories') as $name) {

            $category = (object) null;
            $category->name = $name;
            $category->members = [];

            foreach ($members as $member) {
                if ($member->category === $category->name) {
                    $category->members[] = $member;
                }
            }

            if ($category->members) {
                $categories[] = $category;
            }
        }

        return $categories;
    }

    public function getTeamMemberById($id)
    {
        // Load team member
        if (!$team_member = TeamMember::select('id, first_name, last_name, title, bio, email, phone')
                                      ->where('id', $id)
                                      ->row()) {
            return false;
        }

        // Add photo status
        $team_member->has_photo = is_file(STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg');

        // Convert markdown bio
        $team_member->bio = trim(Markdown::defaultTransform(htmlentities($team_member->bio)));

        // Return team member
        return $team_member;
    }

    public function getTeamMemberBySlug($slug)
    {
        // Load team member
        if (!$team_member = TeamMember::select('id, first_name, last_name, title, bio, email, phone')
                                      ->where('slug', $slug)
                                      ->row()) {
            return false;
        }

        // Add photo status
        $team_member->has_photo = is_file(STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg');

        // Convert markdown bio
        $team_member->bio = trim(Markdown::defaultTransform(htmlentities($team_member->bio)));

        // Return team member
        return $team_member;
    }

    public function getTeamMemberByName($first_name, $last_name)
    {
        // Load team member
        if (!$team_member = TeamMember::select('id, first_name, last_name, title, bio, email, phone')
                                      ->where('first_name', $first_name)
                                      ->and('last_name', $last_name)
                                      ->row()) {
            return false;
        }

        // Add photo status
        $team_member->has_photo = is_file(STORAGE_PATH . 'team/photos/' . $team_member->id . '/medium.jpg');

        // Convert markdown bio
        $team_member->bio = trim(Markdown::defaultTransform(htmlentities($team_member->bio)));

        // Return team member
        return $team_member;
    }

    public function getPhotoResponse($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'team/photos/' . $id . '/' . $size . '.jpg');
    }
}
