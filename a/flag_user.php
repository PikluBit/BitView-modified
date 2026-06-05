<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["user"]
////REQUIRE $_GET["reason"]
if (!$_USER->Logged_In)      { header("location: /"); exit(); }
if (!isset($_GET["user"]))      { header("location: /"); exit(); }
if (!isset($_GET["reason"]))      { header("location: /"); exit(); }
if ($_GET["user"] == $_USER->Username)      { header("location: /"); exit(); }

$_USERCHK = new User($_GET["user"],$DB);
$_USERCHK->get_info();

if (!$_USERCHK->exists()) { header("location: /"); exit(); }
if ($_USERCHK->Is_Moderator || $_USERCHK->Is_Admin) { notification($LANGS['flagmod'],"/user/".$_GET["user"]); exit(); }

if($_GET["reason"] == 1) {
	$DB->modify("INSERT INTO users_flags (reason,username,submit_date) VALUES (1,:USERNAME,NOW())",[":USERNAME" => $_GET["user"]]);
} else {
	$DB->modify("INSERT INTO users_flags (username,submit_date) VALUES (:USERNAME,NOW())",[":USERNAME" => $_GET["user"]]);
}
notification($LANGS['userflagged'],"/user/".$_GET["user"],"cfeeb2"); exit();
