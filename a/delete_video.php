<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["v"]
if (!$_USER->Logged_In)                               { header("location: /login"); exit(); }
if (!isset($_GET["v"]) || mb_strlen((string) $_GET["v"]) > 11) { header("location: /"); exit();          }


$_VIDEO = new Video($_GET["v"],$DB);

if ($_VIDEO->exists()) {

    $_VIDEO->get_info();

    if (($_VIDEO->Info["uploaded_by"] === $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator) && (isset($_GET["did"]) && $_GET["did"] == $_VIDEO->Info["delete_id"])) {
        if ($_VIDEO->delete()) {
            notification($LANGS['videodeleted'],"/my_videos"); exit();
        } else {
            header("location: /"); exit();
        }
    }
}
header("location: /");