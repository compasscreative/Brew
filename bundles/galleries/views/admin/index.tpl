<?
$this->title = 'Galleries';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Galleries</div>
        <ul class="menu">
            <li><a href="/admin/galleries/add">Add new gallery</a></li>
        </ul>
    </div>
    <div class="body">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Photos</th>
                </tr>
            </thead>
            <tbody>
                <? if ($this->galleries): ?>
                    <? foreach ($this->galleries as $gallery): ?>
                        <tr>
                            <td><a href="/admin/galleries/edit/<?=$e($gallery->id)?>/"><?=$e($gallery->title)?></a></td>
                            <td><?=$e($gallery->priority)?></td>
                            <td><?=$e($gallery->photos)?></td>
                        </tr>
                    <? endforeach ?>
                <? else: ?>
                    <tr>
                        <td colspan="3">No galleries found.</td>
                    </tr>
                <? endif ?>
            </tbody>
        </table>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>