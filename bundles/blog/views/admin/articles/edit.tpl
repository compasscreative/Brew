<?
$this->title = 'Editing Blog Article';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Editing Blog Article</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off" id="blog_blog_article_edit">
            <input type="hidden" name="id" value="<?=$e($this->article->id)?>">
            <ul>
                <li>
                    <div class="label">
                        <label>Title:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="title" value="<?=$e($this->article->title)?>" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Published date:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="published_date" value="<?=$e($this->article->published_date)?>" />
                        <div class="error_message required">Required field.</div>
                        <div class="error_message invalid">Not a valid date. Required format: YYYY-MM-DD</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Status:</label>
                    </div>
                    <div class="field">
                        <select name="status">
                            <option <? if ($this->article->status === 'Draft') echo 'selected="selected"'; ?>>Draft</option>
                            <option <? if ($this->article->status === 'Published') echo 'selected="selected"'; ?>>Published</option>
                        </select>
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
                                    <option <? if ($this->article->category_id === $category->id) echo 'selected="selected"'; ?> value="<?=$category->id?>"><?=$category->name?></option>
                                <? endforeach ?>
                            </select>
                        </div>
                    </li>
                <? else: ?>
                    <input type="hidden" name="category_id">
                <? endif ?>
                <li>
                    <div class="label">
                        <label>Body:</label>
                    </div>
                    <div class="field">
                        <textarea name="body" style="height: 300px;"><?=$e($this->article->body)?></textarea>
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
                                    <img class="thumb" src="<?=Config::get('blog::base_url')?>/photo/xsmall/<?=$e($photo->id)?>" width="75" height="75">
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
                        <button class="delete_article" type="button">Delete</button>
                        <button type="button" onclick="javascript:window.location = '/admin/blog/articles';">Done</button>
                    </div>
                    <div class="saved_message">Changes successfully saved.</div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>