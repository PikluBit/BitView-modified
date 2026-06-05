<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////MUST BE ADMIN OR MODERATOR
////IF HE DOESNT HAVE PERMISSION REDIRECT TO ADMIN LOGIN
////REQUIRES $_GET["ue"]
if (!$_USER->Logged_In) { header("location: /"); exit(); }
if (!$_USER->Is_Moderator && !$_USER->Is_Admin) { header("location: /"); exit(); }
if (isset($_GET["page"]) && !$_USER->Has_Permission) { header("location: /admin_panel"); exit(); }
if (!isset($_GET["ue"])) { header("location: /admin_panel"); exit(); }

$UserComs = $DB->execute("SELECT * FROM channel_comments WHERE by_user = :USERNAME ORDER BY submit_date DESC LIMIT 128",false, [":USERNAME" => $_GET["ue"]]);
?>
<a href="/admin_panel/?page=users&ue=<?=$_GET["ue"]?>"><- BACK</a><br /><br />
<?php if ($UserComs) : ?>
<?php foreach ($UserComs as $UserCom) : ?>
<div>From: <b><?= $UserCom["by_user"] ?></b></div>
<div>To: <b><?= $UserCom["on_channel"] ?></b></div>
-------------------------------------------------------------
<div>
    <?php if ($_USER->Is_Admin) : ?>
    <?= nl2br((string) $UserCom["content"]) ?>
    <?php else : ?>
    <?= $UserCom["id"] * 535436 - (299-12*$UserCom["id"]) ?>
    <?php endif ?>
</div>
-------------------------------------------------------------
<div>Date: <?= $UserCom["submit_date"] ?></div>
<br /><br /><br />
<?php endforeach ?>
<?php else : ?>
No Comments were found
<?php endif ?>
