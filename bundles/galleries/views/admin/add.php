<?php
$this->id = 'admin_galleries_add_page';
$this->title = 'Add Gallery';
$this->insert('admin::partials/header');
?>

<div class="panel">
	<div class="header">
		<div class="title">Add Gallery</div>
	</div>
	<div class="body">
		<form autocomplete="off">
			<ul>
				<li>
					<div class="label">
						<label>Title:</label>
					</div>
					<div class="field">
						<input type="text" name="title" />
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
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
						</select>
					</div>
					<div class="instructions">By default galleries are sorted by name. Priority allows you to tweak this order.</div>
				</li>
				<li>
					<div class="label">
						<label>Description:</label>
					</div>
					<div class="field">
						<textarea name="description" style="height: 200px;"></textarea>
					</div>
					<div class="instructions" style="margin-top: 32px;">This field uses Markdown, a handy text to HTML converter. Use the toolbar to see how it works.</div>
				</li>
				<li>
					<div class="buttons">
						<button type="submit">Create</button>
						<button type="button" class="done" onclick="javascript:window.location = '/admin/galleries';">Cancel</button>
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>

<?php $this->insert('admin::partials/footer'); ?>