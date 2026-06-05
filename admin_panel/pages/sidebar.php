<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<div id="nav-pane">
    <div class="header">
        <div class="action-button" id="button-new">
            <span class="yt-menubutton yt-menubutton-primary" id="" style="" onmouseenter="this.className += ' yt-menubutton-primary-hover';" onmouseleave="this.className = this.className.replace(' yt-menubutton-primary-hover', '');"><h1>Admin Panel</h1> </span>
        </div>
    </div>
    <div id="list-pane">
        <div class="folder  <?php if ($_GET["page"] == "main") : ?>selected<?php endif ?>"><a class="name" href="/admin_panel/?page=main">Overview</a></div>
        <div class="folder <?php if ($_GET["page"] == "users") : ?>selected<?php endif ?>"><a class="name" href="/admin_panel/?page=users">Users</a></div>
        <div class="folder <?php if ($_GET["page"] == "videos") : ?>selected<?php endif ?>"><a class="name" href="/admin_panel/?page=videos">Videos</a></div>
        <div class="folder <?php if ($_GET["page"] == "interactions") : ?>selected<?php endif ?>"><a class="name" href="/admin_panel/?page=interactions">Interactions</a></div>
        <div class="folder <?php if ($_GET["page"] == "contest") : ?>selected<?php endif ?>"><a class="name" href="/admin_panel/?page=contest">Contests</a></div>
        <div class="folder <?php if ($_GET["page"] == "stats") : ?>selected<?php endif ?>"><a class="name" href="/admin_panel/?page=stats">Statistics</a></div>
        <?php if ($_USER->Is_Admin):?><div class="folder <?php if ($_GET["page"] == "log") : ?>selected<?php endif ?>"><a class="name" href="/admin_panel/?page=log">Audit Log</a></div><?php endif ?>
        <div class="folder <?php if ($_GET["page"] == "config") : ?>selected<?php endif ?> "><a class="name" href="/admin_panel/?page=config">Settings</a></div>

    </div>
</div>