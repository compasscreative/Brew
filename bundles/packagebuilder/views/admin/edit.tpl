<?
$this->title = 'Editing Option | Package Builder';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Editing Option</div>
        <ul class="menu">
            <li><a href="/admin/package-builder/add">Add option</a></li>
        </ul>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off" id="packagebuilder_option_edit">
            <input type="hidden" name="id" value="<?=$e($this->option->id)?>">
            <ul>
                <li>
                    <div class="label">
                        <label>Name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="name" value="<?=$e($this->option->name)?>">
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Small:</label>
                    </div>
                    <div class="field">
                        <div>
                            <label class="sub_label">Low Price:</label>
                            <input type="text" name="small_price_1" value="<?=$e($this->option->small_price_1)?>">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <div>
                            <label class="sub_label">High Price:</label>
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                            <input type="text" name="small_price_2" value="<?=$e($this->option->small_price_2)?>">
                        </div>
                        <label class="sub_label">Description:</label>
                        <textarea name="small_description" style="height: 40px;"><?=$e($this->option->small_description)?></textarea>
                        <label class="sub_label">Photo:</label>
                        <div class="photo small">
                            <? if ($this->option->small_photo_url): ?>
                                <img src="<?=$e($this->option->small_photo_url)?>">
                            <? endif ?>
                            <p></p>
                            <a>Upload Photo</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Medium:</label>
                    </div>
                    <div class="field">
                        <div>
                            <label class="sub_label">Low Price:</label>
                            <input type="text" name="medium_price_1" value="<?=$e($this->option->medium_price_1)?>">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <div>
                            <label class="sub_label">High Price:</label>
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                            <input type="text" name="medium_price_2" value="<?=$e($this->option->medium_price_2)?>">
                        </div>
                        <label class="sub_label">Description:</label>
                        <textarea name="medium_description" style="height: 40px;"><?=$e($this->option->medium_description)?></textarea>
                        <label class="sub_label">Photo:</label>
                        <div class="photo medium">
                            <? if ($this->option->medium_photo_url): ?>
                                <img src="<?=$e($this->option->medium_photo_url)?>">
                            <? endif ?>
                            <p></p>
                            <a>Upload Photo</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Large:</label>
                    </div>
                    <div class="field">
                        <div>
                            <label class="sub_label">Low Price:</label>
                            <input type="text" name="large_price_1" value="<?=$e($this->option->large_price_1)?>">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <div>
                            <label class="sub_label">High Price:</label>
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                            <input type="text" name="large_price_2" value="<?=$e($this->option->large_price_2)?>">
                        </div>
                        <label class="sub_label">Description:</label>
                        <textarea name="large_description" style="height: 40px;"><?=$e($this->option->large_description)?></textarea>
                        <label class="sub_label">Photo:</label>
                        <div class="photo large">
                            <? if ($this->option->large_photo_url): ?>
                                <img src="<?=$e($this->option->large_photo_url)?>">
                            <? endif ?>
                            <p></p>
                            <a>Upload Photo</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Save Changes</button>
                        <button class="delete" type="button" class="">Delete</button>
                        <button type="button" onclick="javascript:window.location = '/admin/package-builder';">Done</button>
                    </div>
                    <div class="saved_message">Changes successfully saved.</div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>