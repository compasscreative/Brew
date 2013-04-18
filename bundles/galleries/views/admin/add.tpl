<?
$this->title = 'Add Gallery';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Add Gallery</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off">
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

<? $this->insert('admin::partials/footer') ?>