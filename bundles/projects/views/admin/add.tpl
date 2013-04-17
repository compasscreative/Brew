<?
$this->title = 'Add Project';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Add Project</div>
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
                        <label>Date Completed:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="completed_date" value="<?=date('Y-m-d')?>" />
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
                        <input type="text" name="introduction" />
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
                    <div class="label">
                        <label>Awards:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="awards" />
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Landscape Ontario:</label>
                    </div>
                    <div class="field">
                        <select name="show_lo_award">
                            <option value="1">Show award</option>
                            <option value="0">Do not show award</option>
                        </select>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Create</button>
                        <button type="button" class="done" onclick="javascript:window.location = '/admin/projects';">Cancel</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>