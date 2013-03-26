<?
$this->title = 'Add Blog Category';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Add Blog Category</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off" id="blog_blog_category_add">
            <ul>
                <li>
                    <div class="label">
                        <label>Name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="name" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Create</button>
                        <button type="button" class="done" onclick="javascript:window.location = '/admin/blog/categories';">Cancel</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>