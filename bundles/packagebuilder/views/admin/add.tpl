<?
$this->title = 'Add Option | Package Builder';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Add Option</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off">
            <ul>
                <li>
                    <div class="label">
                        <label>Name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="name" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Section:</label>
                    </div>
                    <div class="field">
                        <select name="section">
                            <? foreach ($this->sections as $section): ?>
                                <option><?=$section?></option>
                            <? endforeach ?>
                        </select>
                    </div>
                    <div class="instructions">
                        Note that this field cannot be changed once created.
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Small:</label>
                    </div>
                    <div class="field">
                        <div>
                            <label class="sub_label">Low Price:</label>
                            <input type="text" name="small_price_1">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <div>
                            <label class="sub_label">High Price:</label>
                            <input type="text" name="small_price_2">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <label class="sub_label">Description:</label>
                        <textarea name="small_description" style="height: 40px;"></textarea>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Medium:</label>
                    </div>
                    <div class="field">
                        <div>
                            <label class="sub_label">Low Price:</label>
                            <input type="text" name="medium_price_1">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <div>
                            <label class="sub_label">High Price:</label>
                            <input type="text" name="medium_price_2">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <label class="sub_label">Description:</label>
                        <textarea name="medium_description" style="height: 40px;"></textarea>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Large:</label>
                    </div>
                    <div class="field">
                        <div>
                            <label class="sub_label">Low Price:</label>
                            <input type="text" name="large_price_1">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <div>
                            <label class="sub_label">High Price:</label>
                            <input type="text" name="large_price_2">
                            <div class="error_message required">Required field.</div>
                            <div class="error_message invalid">Not a valid number.</div>
                        </div>
                        <label class="sub_label">Description:</label>
                        <textarea name="large_description" style="height: 40px;"></textarea>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Create</button>
                        <button type="button" class="done" onclick="javascript:window.location = '/admin/package-builder';">Cancel</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>