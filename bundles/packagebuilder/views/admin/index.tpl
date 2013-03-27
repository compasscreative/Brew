<?
$this->title = 'Package Builder';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Package Builder</div>
        <ul class="menu">
            <li><a href="/admin/package-builder/add">Add option</a></li>
        </ul>
    </div>
    <div class="body">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Small</th>
                    <th>Medium</th>
                    <th>Large</th>
                </tr>
            </thead>
            <tbody>
                <? if ($this->options): ?>
                    <? foreach ($this->options as $option): ?>
                        <tr>
                            <td><a href="/admin/package-builder/edit/<?=$option->id?>/"><?=$e($option->name)?></a></td>
                            <td><?=$e($option->section)?></td>
                            <td><?=$e($option->small_price_1)?> to <?=$e($option->small_price_2)?></td>
                            <td><?=$e($option->medium_price_1)?> to <?=$e($option->medium_price_2)?></td>
                            <td><?=$e($option->large_price_1)?> to <?=$e($option->large_price_2)?></td>
                        </tr>
                    <? endforeach ?>
                <? else: ?>
                    <tr>
                        <td colspan="5">No options found.</td>
                    </tr>
                <? endif ?>
            </tbody>
        </table>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>