<?
$this->title = 'Add Team Member';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Add Team Member</div>
    </div>
    <div class="body">
        <form class="standard" autocomplete="off" id="team_team_member_add">
            <ul>
                <li>
                    <div class="label">
                        <label>First name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="first_name" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Last name:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="last_name" />
                        <div class="error_message required">Required field.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Title:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="title" />
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Bio:</label>
                    </div>
                    <div class="field">
                        <textarea name="bio" style="height: 200px;"></textarea>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Email:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="email" />
                        <div class="error_message invalid">Invalid email address.</div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        <label>Phone:</label>
                    </div>
                    <div class="field">
                        <input type="text" name="phone" />
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button type="submit">Create</button>
                        <button type="button" class="done" onclick="javascript:window.location = '/admin/galleries';">Cancel</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>