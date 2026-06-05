<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////MUST BE ADMIN OR MODERATOR
////IF HE DOESNT HAVE PERMISSION REDIRECT TO ADMIN LOGIN
////REQUIRES $_GET["ue"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!$_USER->Is_Moderator && !$_USER->Is_Admin) {
    header("location: /");
    exit();
}
if (isset($_GET["page"]) && !$_USER->Has_Permission) {
    header("location: /admin_panel");
    exit();
}
if (!isset($_GET["ue"])) {
    header("location: /admin_panel");
    exit();
}

$DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Showed privated messages for '.$_GET["ue"]]);

$Messages = $DB->execute("SELECT * FROM users_messages WHERE for_user = :USERNAME ORDER BY submit_on DESC LIMIT 128", false, [":USERNAME" => $_GET["ue"]]);
?>
<a href="/admin_panel/?page=interactions"><- BACK</a><br /><br />
<?php if ($Messages) : ?>
<?php foreach ($Messages as $Message) : ?>
<div>From: <b><?= $Message["by_user"] ?></b></div>
<div>To: <b><?= $Message["for_user"] ?></b></div>
-------------------------------------------------------------
<div>
    <?php if ($_USER->Is_Admin) : ?>
    <?= nl2br((string) $Message["content"]) ?>
    <?php else : ?>
    <?= $Message["id"] * 535436 - (299-12*$Message["id"]) ?>
    <?php endif ?>
</div>
-------------------------------------------------------------
<div>Date: <?= $Message["submit_on"] ?></div>
<br /><br /><br />
<?php endforeach ?>
<?php else : ?>
No Messages were found
<?php endif ?>
