<?
$this->title = 'Projects';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Projects</div>
        <ul class="menu">
            <li><a href="/admin/projects/add">Add new project</a></li>
        </ul>
    </div>
    <div class="body">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date Completed</th>
                    <th>LO Award</th>
                    <th>Photos</th>
                </tr>
            </thead>
            <tbody>
                <? if ($this->projects): ?>
                    <? foreach ($this->projects as $project): ?>
                        <tr>
                            <td><a href="/admin/projects/edit/<?=$project->id?>/"><?=$e($project->title)?></a></td>
                            <td><?=date_create($project->completed_date)->format('M j, Y')?></td>
                            <td><?=$project->show_lo_award ? 'Yes' : 'No'?></td>
                            <td><?=$e($project->photos)?></td>
                        </tr>
                    <? endforeach ?>
                <? else: ?>
                    <tr>
                        <td colspan="4">No projects found.</td>
                    </tr>
                <? endif ?>
            </tbody>
        </table>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>