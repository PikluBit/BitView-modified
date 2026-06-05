<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////"$_GET["v"]" MUST BE SET
if (!$_USER->Logged_In) { header("location: /login"); exit(); }
if (!isset($_GET["v"])) { header("location: /"); exit(); }

//MAIN VIDEO
$_VIDEO = new Video($_GET["v"],$DB);

if (!$_VIDEO->exists()) { header("location: /my_videos"); exit(); }

$_VIDEO->get_info();
$_VIDEO->check_info();

if ($_VIDEO->Info["uploaded_by"] !== $_USER->Username) { header("location: /my_videos"); exit(); }

$_USER->get_info();

$_PAGE = [
    "Page"          => "my_videos_annotations",
    "Page_Type"     => "my_videos",
];
require "_templates/_structures/main.php";