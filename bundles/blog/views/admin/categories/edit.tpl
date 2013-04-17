<?
$this->title = 'Editing Blog Category';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Editing Blog Category</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off">
            <input type="hidden" name="id" value="<?=$e($this->category->id)?>">
            <ul>
                <li>
                    <div class="label">
                        <label>Name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="name" value="<?=$e($this->category->name)?>" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Save Changes</button>
                        <button class="delete_category" type="button" class="">Delete</button>
                        <button type="button" onclick="javascript:window.location = '/admin/blog/categories';">Done</button>
                    </div>
                    <div class="saved_message">Changes successfully saved.</div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>