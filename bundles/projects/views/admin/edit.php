<?php
$this->id = 'admin_projects_edit_page';
$this->title = 'Editing Project';
$this->insert('admin::partials/header');
?>

<div class="panel">
	<div class="header">
		<div class="title">Editing Project</div>
	</div>
	<div class="body">
		<form autocomplete="off" id="projects_project_edit">
			<input type="hidden" name="id" value="<?=$this->project->id?>">
			<ul>
				<li>
					<div class="label">
						<label>Title:</label>
					</div>
					<div class="field">
						<input type="text" name="title" value="<?=htmlspecialchars($this->project->title)?>" />
						<div class="error_message required">Required field.</div>
					</div>
				</li>
				<li>
					<div class="label">
						<label>Date Completed:</label>
					</div>
					<div class="field">
						<input type="text" name="completed_date" value="<?=date_create($this->project->completed_date)->format('Y-m-d')?>" />
						<div class="error_message required">Required field.</div>
						<div class="error_message invalid">Not a valid date. Required format: YYYY-MM-DD</div>
					</div>
					<div class="instructions">Not published on the website, however it is used to order the projects.</div>
				</li>
				<li>
					<div class="label">
						<label>Introduction:</label>
					</div>
					<div class="field">
						<input type="text" name="introduction" value="<?=htmlspecialchars($this->project->introduction)?>" />
					</div>
				</li>
				<li>
					<div class="label">
						<label>Description:</label>
					</div>
					<div class="field">
						<textarea name="description" style="height: 200px;"><?=htmlspecialchars($this->project->description)?></textarea>
					</div>
					<div class="instructions" style="margin-top: 32px;">This field uses Markdown, a handy text to HTML converter. Use the toolbar to see how it works.</div>
				</li>
				<li>
					<div class="label">
						<label>Awards:</label>
					</div>
					<div class="field">
						<input type="text" name="awards" value="<?=htmlspecialchars($this->project->awards)?>" />
					</div>
				</li>
				<li>
					<div class="label">
						<label>Landscape Ontario:</label>
					</div>
					<div class="field">
						<select name="show_lo_award">
							<option <?php if ($this->project->show_lo_award === '1') echo 'selected="selected"'; ?> value="1">Show award</option>
							<option <?php if ($this->project->show_lo_award === '0') echo 'selected="selected"'; ?> value="0">Do not show award</option>
						</select>
					</div>
				</li>
				<li>
					<div class="label">
						<label>Photos:</label>
					</div>
					<div class="field photos">
						<ul>
							<?php foreach (array('Before', 'Design', 'Construction', 'Finished') as $section){ ?>
								<li class="seperator">
									<input type="hidden" name="photos[][seperator]" value="<?=$section?>">
									<?=$section?>
								</li>
								<?php
									foreach ($this->photos as $photo)
									{
										if ($photo->section === $section)
										{
											echo '<li>';
											echo '<img class="thumb" src="/projects/photo/xsmall/' . $photo->id . '" width="75" height="75">';
											echo '<div class="tools">';
											echo '<textarea name="photos[][photo][' . $photo->id . ']">' . $photo->caption . '</textarea>';
											echo '<button type="button" data-id="' . $photo->id . '" class="delete_photo">Delete</button>';
											echo '</div>';
											echo '</li>';
										}
									}
								?>
							<?php } ?>
						</ul>
					</div>
				</li>
				<li>
					<div class="buttons">
						<button type="submit">Save Changes</button>
						<a class="upload_photo">Upload Photos</a>
						<button class="delete_project" type="button" class="">Delete</button>
						<button type="button" onclick="javascript:window.location = '/admin/projects';">Done</button>
					</div>
					<div class="saved_message">
						Changes successfully saved.
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>

<?php $this->insert('admin::partials/footer'); ?>