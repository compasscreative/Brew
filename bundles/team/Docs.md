Team
====

## Example Routes

```php
<?php
Router::get(
    '/team',
    function () {

        // Create API
        $api = new \Brew\Team\API();

        // Get categories
        $team_categories = $api->getCategories();

        // Load all team members
        $team_members = $api->getAllTeamMembers();

        // Return view
        return Response::view(
            'team',
            [
                'team_categories' => $team_categories,
                'team_members' => $team_members
            ]
        );
    }
);

Router::get(
    '/team/([0-9]+)/([a-z-0-9]+)',
    function ($id, $slug) {

        // Create API
        $api = new \Brew\Team\API();

        // Load team member
        if (!$team_member = $api->getTeamMember($id)) {
            return Response::notFound();
        }

        // Validate slug
        if ($team_member->slug !== $slug) {
            return Response::redirect('/team/' . $team_member->id . '/' . $team_member->slug);
        }

        // Return view
        return Response::view(
            'team_member',
            [
                'team_member' => $team_member
            ]
        );
    }
);

Router::get(
    '/team/photo/(xlarge|large|medium|small|xsmall)/([0-9]+)',
    function ($size, $id) {

        // Create API
        $api = new \Brew\Team\API();

        // Return photo
        return $api->getPhotoResponse($size, $id);
    }
);
```

## Example Views

### Index Page
```php
<?
$this->title = 'Team';
$this->insert('partials/header');
?>

<h1>Team</h1>

<? if ($this->team_members): ?>
    <? foreach ($this->team_categories as $category): ?>
        <h2><?=$e($category)?></h2>
        <ul>
            <? foreach ($this->team_members as $team_member): ?>
                <? if ($team_member->category !== $category) continue; ?>
                <li id="<?=$team_member->id?>">
                    <a href="/admin/team/edit/<?=$e($team_member->id)?>/">
                        <? if ($team_member->has_photo): ?>
                            <img src="/team/photo/small/<?=$e($team_member->id)?>" alt="<?=$e($team_member->first_name)?> <?=$e($team_member->last_name)?>">
                        <?php else: ?>
                            <!-- Insert blank photo here -->
                        <? endif ?>
                        <h3><?=$e($team_member->first_name)?> <?=$e($team_member->last_name)?></h3>
                        <h4><?=$e($team_member->title)?></h4>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    <? endforeach ?>
<? else: ?>
    <p>No team members found.</p>
<? endif ?>

<? $this->insert('partials/footer') ?>
```

### Team Member Page

```php
<?
$this->title = $e($this->team_member->first_name) . ' ' . $e($this->team_member->last_name) . ' | Team';
$this->insert('partials/header');
?>

<? if ($this->team_member->has_photo): ?>
    <img src="/team/photo/medium/<?=$e($this->team_member->id)?>">
<? endif ?>

<h1><?=$e($this->team_member->first_name)?> <?=$e($this->team_member->last_name)?></h1>

<? if ($this->team_member->title): ?>
    <h2>Title:</h2>
    <p><?=$e($this->team_member->title)?></p>
<? endif ?>

<? if ($this->team_member->bio): ?>
    <h2>Bio:</h2>
    <?=$this->team_member->bio?>
<? endif ?>

<? if ($this->team_member->email): ?>
    <h2>Email:</h2>
    <p><a href="mailto:<?=$e($this->team_member->email)?>"><?=$e($this->team_member->email)?></a></p>
<? endif ?>

<? if ($this->team_member->phone): ?>
    <h2>Phone:</h2>
    <p><?=$e($this->team_member->phone)?></p>
<? endif ?>

<? $this->insert('partials/footer') ?>
```