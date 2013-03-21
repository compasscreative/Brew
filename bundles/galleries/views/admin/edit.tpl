<?
$this->title = 'Editing Gallery';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Editing Gallery</div>
    </div>
    <div class="body">
        <form autocomplete="off" id="galleries_gallery_edit">
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
                        <label>Priority:</label>
                    </div>
                    <div class="field">
                        <select name="priority">
                            <option value="0"></option>
                            <option value="1" <? if ($this->gallery->priority === '1') echo 'selected="selected"'; ?>>1</option>
                            <option value="2" <? if ($this->gallery->priority === '2') echo 'selected="selected"'; ?>>2</option>
                            <option value="3" <? if ($this->gallery->priority === '3') echo 'selected="selected"'; ?>>3</option>
                            <option value="4" <? if ($this->gallery->priority === '4') echo 'selected="selected"'; ?>>4</option>
                            <option value="5" <? if ($this->gallery->priority === '5') echo 'selected="selected"'; ?>>5</option>
                            <option value="6" <? if ($this->gallery->priority === '6') echo 'selected="selected"'; ?>>6</option>
                            <option value="7" <? if ($this->gallery->priority === '7') echo 'selected="selected"'; ?>>7</option>
                            <option value="8" <? if ($this->gallery->priority === '8') echo 'selected="selected"'; ?>>8</option>
                            <option value="9" <? if ($this->gallery->priority === '9') echo 'selected="selected"'; ?>>9</option>
                            <option value="10" <? if ($this->gallery->priority === '10') echo 'selected="selected"'; ?>>10</option>
                        </select>
                    </div>
                    <div class="instructions">By default galleries are sorted by name. Priority allows you to tweak this order.</div>
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
                            <? foreach ($this->photos as $photo): ?>
                                <li>
                                    <img class="thumb" src="<?=Config::get('galleries::base_url')?>/photo/xsmall/<?=$e($photo->id)?>" width="75" height="75">
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