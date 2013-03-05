<?php
$this->id = 'admin_galleries_edit_page';
$this->title = 'Editing Gallery';
$this->insert('admin::partials/header');
?>

<div class="panel">
	<div class="header">
		<div class="title">Editing Gallery</div>
	</div>
	<div class="body">
		<form autocomplete="off">
			<input type="hidden" name="id" value="<?=htmlspecialchars($this->gallery->id)?>">
			<ul>
				<li>
					<div class="label">
						<label>Title:</label>
					</div>
					<div class="field">
						<input type="text" name="title" value="<?=htmlspecialchars($this->gallery->title)?>" />
						<div class="error_message required">Required field.</div>
					</div>
				</li>
				<li>
					<div class="label">
						<label>Priority:</label>
					</div>
					<div class="field">
						<select name="priority">
							<option></option>
							<option <?php if ($this->gallery->priority === '1') echo 'selected="selected"'; ?>>1</option>
							<option <?php if ($this->gallery->priority === '2') echo 'selected="selected"'; ?>>2</option>
							<option <?php if ($this->gallery->priority === '3') echo 'selected="selected"'; ?>>3</option>
							<option <?php if ($this->gallery->priority === '4') echo 'selected="selected"'; ?>>4</option>
							<option <?php if ($this->gallery->priority === '5') echo 'selected="selected"'; ?>>5</option>
							<option <?php if ($this->gallery->priority === '6') echo 'selected="selected"'; ?>>6</option>
							<option <?php if ($this->gallery->priority === '7') echo 'selected="selected"'; ?>>7</option>
							<option <?php if ($this->gallery->priority === '8') echo 'selected="selected"'; ?>>8</option>
							<option <?php if ($this->gallery->priority === '9') echo 'selected="selected"'; ?>>9</option>
							<option <?php if ($this->gallery->priority === '10') echo 'selected="selected"'; ?>>10</option>
						</select>
					</div>
					<div class="instructions">By default galleries are sorted by name. Priority allows you to tweak this order.</div>
				</li>
				<li>
					<div class="label">
						<label>Description:</label>
					</div>
					<div class="field">
						<textarea name="description" style="height: 200px;"><?=htmlspecialchars($this->gallery->description)?></textarea>
					</div>
					<div class="instructions" style="margin-top: 32px;">This field uses Markdown, a handy text to HTML converter. Use the toolbar to see how it works.</div>
				</li>
				<li>
					<div class="label">
						<label>Photos:</label>
					</div>
					<div class="field photos">
						<ul>
							<?php
								foreach ($this->photos as $photo)
								{
									echo '<li>';
									echo '<img class="thumb" src="/photo-galleries/photo/xsmall/' . $photo->id . '" width="75" height="75">';
									echo '<div class="tools">';
									echo '<textarea name="photos[' . $photo->id . ']">' . $photo->caption . '</textarea>';
									echo '<button type="button" data-id="' . $photo->id . '" class="delete_photo">Delete</button>';
									echo '</div>';
									echo '</li>';
								}
							?>
						</ul>
					</div>
				</li>
				<li>
					<div class="buttons">
						<button type="submit">Save Changes</button>
						<a class="upload_photo">Upload Photos</a>
						<button class="delete_gallery" type="button" class="">Delete</button>
						<button type="button" onclick="javascript:window.location = '/admin/galleries';">Done</button>
					</div>
					<div class="saved_message">Changes successfully saved.</div>
				</li>
			</ul>
		</form>
	</div>
</div>

<?php $this->insert('admin::partials/footer'); ?>