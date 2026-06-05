<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

if (!$_USER->Logged_In) { header("location: /"); exit(); }
if (!isset($_GET["v"])) { header("location: /"); exit(); }

$_VIDEO = new Video($_GET["v"], $DB);

if ($_VIDEO->exists()) {
    $_VIDEO->get_info();

    if ($_USER->Username == $_VIDEO->Info["uploaded_by"]) {
        if ($_USER->change_avatar($_VIDEO)) {
            notification($LANGS['avatarsuccess'], $_SERVER["HTTP_REFERER"], "cfeeb2");exit();
        }
    }
}
notification("Something went wrong, sorry about that!", $_SERVER["HTTP_REFERER"]);