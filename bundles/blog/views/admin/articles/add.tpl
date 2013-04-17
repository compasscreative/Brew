<?
$this->title = 'Add Blog Article';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Add Blog Article</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off">
            <ul>
                <li>
                    <div class="label">
                        <label>Title:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="title" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Published date:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="published_date" value="<?=date('Y-m-d')?>" />
                        <div class="error_message required">Required field.</div>
                        <div class="error_message invalid">Not a valid date. Required format: YYYY-MM-DD</div>
                    </div>
                </li>

                <? if ($this->categories): ?>
                    <li>
                        <div class="label">
                            <label>Category:</label>
                        </div>
                        <div class="field">
                            <select name="category_id">
                                <option></option>
                                <? foreach ($this->categories as $category): ?>
                                    <option value="<?=$category->id?>"><?=$category->name?></option>
                                <? endforeach ?>
                            </select>
                        </div>
                    </li>
                <? else: ?>
                    <input type="hidden" name="category_id">
                <? endif ?>

                <? if (Config::get('blog::enable_type_option')): ?>
                    <li>
                        <div class="label">
                            <label>Type:</label>
                        </div>
                        <div class="field">
                            <select name="type">
                                <option value="Markdown">Markdown (recommended)</option>
                                <option value="HTML">HTML</option>
                            </select>
                        </div>
                    </li>
                <? else: ?>
                    <input type="hidden" name="type" value="Markdown">
                <? endif ?>

                <li>
                    <div class="buttons">
                        <button type="submit">Create</button>
                        <button type="button" class="done" onclick="javascript:window.location = '/admin/blog';">Cancel</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>