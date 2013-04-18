<?
$this->title = 'Add Product';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Add Product</div>
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
                        <label>Introduction:</label>
                    </div>
                    <div class="field">
                        <textarea name="introduction" style="height: 60px;"></textarea>
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
                        <label>Title Tag:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="title_tag" />
                    </div>
                    <div class="instructions">A custom browser page title. Shouldn’t be longer than 70 characters.</div>
                </li>
                <li>
                    <div class="label">
                        <label>Description Tag:</label>
                    </div>
                    <div class="field">
                        <textarea name="description_tag" style="height: 42px;"></textarea>
                    </div>
                    <div class="instructions">The description tag often appears with search engine results. Shouldn’t be longer than 150 characters.</div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Create</button>
                        <button type="button" class="done" onclick="javascript:window.location = '/admin/products';">Cancel</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>