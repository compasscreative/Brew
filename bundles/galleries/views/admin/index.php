<?php
$this->id = 'admin_galleries_page';
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
                <?php if ($this->galleries) { ?>
                    <?php foreach ($this->galleries as $gallery) { ?>
                        <tr>
                            <td><a href="/admin/galleries/edit/<?=$gallery->id?>/"><?=$gallery->title?></a></td>
                            <td><?=$gallery->priority?></td>
                            <td><?=$gallery->photos?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">No galleries found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->insert('admin::partials/footer');
