<?
$this->title = 'Blog Categories';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Blog Categories</div>
        <ul class="menu">
            <li><a href="/admin/blog/category/add">Add new category</a></li>
            <li><a href="/admin/blog/articles">Edit articles</a></li>
        </ul>
    </div>
    <div class="body">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <? if ($this->categories): ?>
                    <? foreach ($this->categories as $category): ?>
                        <tr>
                            <td><a href="/admin/blog/categories/edit/<?=$e($category->id)?>/"><?=$e($category->name)?></a></td>
                        </tr>
                    <? endforeach ?>
                <? else: ?>
                    <tr>
                        <td colspan="1">No categories found.</td>
                    </tr>
                <? endif ?>
            </tbody>
        </table>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>