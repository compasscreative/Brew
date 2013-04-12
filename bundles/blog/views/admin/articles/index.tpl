<?
$this->title = 'Blog Articles';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Blog Articles</div>
        <ul class="menu">
            <li><a href="/admin/blog/article/add">Add new article</a></li>
            <li><a href="/admin/blog/categories">Edit categories</a></li>
        </ul>
    </div>
    <div class="body">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Published date</th>
                    <? if (Config::get('blog::enable_type_option')): ?>
                        <th>Type</th>
                    <? endif ?>
                </tr>
            </thead>
            <tbody>
                <? if ($this->articles): ?>
                    <? foreach ($this->articles as $article): ?>
                        <tr>
                            <td><a href="/admin/blog/article/edit/<?=$e($article->id)?>/"><?=$e($article->title)?></a></td>
                            <td><?=$e($article->category_name)?></td>
                            <td><?=$e($article->status)?></td>
                            <td><?=$e(date_create($article->published_date)->format('F d, Y'))?></td>
                            <? if (Config::get('blog::enable_type_option')): ?>
                                <td><?=$e($article->type)?></td>
                            <? endif ?>
                        </tr>
                    <? endforeach ?>
                <? else: ?>
                    <tr>
                        <? if (Config::get('blog::enable_type_option')): ?>
                            <td colspan="5">No blog articles found.</td>
                        <? else: ?>
                            <td colspan="4">No blog articles found.</td>
                        <? endif ?>
                    </tr>
                <? endif ?>
            </tbody>
        </table>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>