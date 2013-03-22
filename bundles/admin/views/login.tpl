<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login | Admin</title>
    <?=Asset::css('/css/admin.css')?>
</head>

<body>

<div class="container login">
    <div class="header">
        <h1><?=Config::get('admin::company')?></h1>
    </div>
    <div class="panel">
        <div class="header">
            <div class="title">Login</div>
        </div>
        <div class="body">
            <form class="standard" action="/admin/login" method="post">
                <ul>
                    <li>
                        <div class="label">
                            <label>Username:</label>
                        </div>
                        <div class="field">
                            <input type="text" name="username" value="<? if (isset($_POST['username'])) echo $_POST['username']; ?>" />
                        </div>
                    </li>
                    <li>
                        <div class="label">
                            <label>Password:</label>
                        </div>
                        <div class="field">
                            <input type="password" name="password" value="<? if (isset($_POST['password'])) echo $_POST['password']; ?>" />
                            <? if (count($_POST)): ?>
                                <div class="error_message required" style="display: block;">Login failed.</div>
                            <? endif ?>
                        </div>
                    </li>
                    <li>
                        <div class="buttons">
                            <button type="submit">Login</button>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>

</body>
</html>