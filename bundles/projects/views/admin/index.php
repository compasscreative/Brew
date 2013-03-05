<?php
$this->id = 'admin_projects_page';
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
				<?php if($this->projects){ ?>
					<?php foreach($this->projects as $project){ ?>
						<tr>
							<td><a href="/admin/projects/edit/<?=$project->id?>/"><?=$project->title?></a></td>
							<td><?=date_create($project->date_completed)->format('M j, Y')?></td>
							<td><?=$project->show_lo_award ? 'Yes' : 'No'?></td>
							<td><?=$project->photos?></td>
						</tr>
					<?php } ?>
				<?php } else { ?>
					<tr>
						<td colspan="4">No projects found.</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php $this->insert('admin::partials/footer'); ?>