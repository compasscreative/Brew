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
                        </tr>
                    <? endforeach ?>
                <? else: ?>
                    <tr>
                        <td colspan="4">No blog articles found.</td>
                    </tr>
                <? endif ?>
            </tbody>
        </table>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>