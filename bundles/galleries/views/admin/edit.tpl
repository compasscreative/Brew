<?
$this->title = 'Editing Gallery';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Editing Gallery</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off">
            <input type="hidden" name="id" value="<?=$e($this->gallery->id)?>">
            <ul>
                <li>
                    <div class="label">
                        <label>Title:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="title" value="<?=$e($this->gallery->title)?>" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Description:</label>
                    </div>
                    <div class="field">
                        <textarea name="description" style="height: 200px;"><?=$e($this->gallery->description)?></textarea>
                    </div>
                    <div class="instructions" style="margin-top: 32px;">This field uses Markdown, a handy text to HTML converter. Use the toolbar to see how it works.</div>
                </li>
                <li>
                    <div class="label">
                        <label>Photos:</label>
                    </div>
                    <div class="field photos">
                        <ul>
                            <li class="no_photos" <? if ($this->photos) echo 'style="display: none;"'; ?>>
                                No photos set.
                            </li>
                            <? foreach ($this->photos as $photo): ?>
                                <li>
                                    <img class="thumb" src="/admin/galleries/photo/<?=$e($photo->id)?>" width="75" height="75">
                                    <div class="tools">
                                        <textarea name="photos[<?=$e($photo->id)?>]"><?=$e($photo->caption)?></textarea>
                                        <button type="button" data-id="<?=$e($photo->id)?>" class="delete_photo">Delete</button>
                                    </div>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Save Changes</button>
                        <a class="upload_photo">Upload Photos</a>
                        <button class="delete_gallery" type="button" class="">Delete</button>
                        <button type="button" onclick="javascript:window.location = '/admin/galleries';">Done</button>
                    </div>
                    <div class="saved_message">Changes successfully saved.</div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>