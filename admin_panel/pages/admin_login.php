<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<div id="sectionHeader" class="communityColor">
    <div class="name" align="left" style="width:500px;">Sign in to BitView's Admin Panel!</div><br>
</div>
<div style="margin: 12px auto;width: 875px;">
<div style="float:left;width:526px;">
    <span class="highlight">What is this?</span>
    <br><br>
    This is the BitView Admin Panel which allows the administrators and moderators of BitView control the site and support its users.
    <ul>
        <li>Curate videos and users to keep the site clean</li>
        <li>Write Blog Posts</li>
        <li>Only admins and moderators are allowed to see this page, it's being heavily monitored!</li>
        <li>... and much, much more!</li>
    </ul>
</div>
<div style="float:right;border: 1px solid #c3d9ff;padding: 4px;margin-bottom: 12px;">
    <div class="login_box" style="background-color: #e8eefa;">
        <div style="margin: 5px 0 9px;font-weight:bold;color: #003366;font-size:16px;text-align:center">
            Admin Login
        </div>
        <form action="/admin_panel/?next=<?php if (isset($_GET['next'])): ?><?= urlencode((string) $_GET['next']) ?><?php else: ?><?= urlencode('page=main') ?><?php endif ?>" method="POST">
            <table width="100%" cellpadding="5" cellspacing="0" border="0">
                <tr>
                    <td align="right"><span>Username:</span></td>
                    <td><input type="text" size="20" maxlength="20" name="username" value="<?= $_USER->Username ?>" /></td>
                </tr>
                <tr>
                    <td align="right"><span>Password:</span></td>
                    <td><input type="password" size="20" maxlength="128" name="password" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="admin_log_in" value="Sign In" /></td>
                </tr>
            </table>
        </form>
    </div>
</div>