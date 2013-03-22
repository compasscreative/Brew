<?
$this->title = 'Editing Team Member';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Editing Team Member</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off" id="team_team_member_edit">
            <input type="hidden" name="id" value="<?=$e($this->team_member->id)?>">
            <ul>
                <li>
                    <div class="label">
                        <label>First name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="first_name" value="<?=$e($this->team_member->first_name)?>" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Last name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="last_name" value="<?=$e($this->team_member->last_name)?>" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Title:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="title" value="<?=$e($this->team_member->title)?>" />
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Bio:</label>
                    </div>
                    <div class="field">
                        <textarea name="bio" style="height: 200px;"><?=$e($this->team_member->bio)?></textarea>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Email:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="email" value="<?=$e($this->team_member->email)?>" />
                        <div class="error_message invalid">Invalid email address.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Phone:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="phone" value="<?=$e($this->team_member->phone)?>" />
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Photo:</label>
                    </div>
                    <div class="field photo">
                        <? if ($this->team_member->photo_url): ?>
                            <img src="<?=$this->team_member->photo_url?>">
                        <? else: ?>
                            <div class="info">No photo set.</div>
                        <? endif ?>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Save Changes</button>
                        <a class="upload_photo">Upload Photo</a>
                        <button class="delete" type="button" class="">Delete</button>
                        <button type="button" onclick="javascript:window.location = '/admin/team';">Done</button>
                    </div>
                    <div class="saved_message">Changes successfully saved.</div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>