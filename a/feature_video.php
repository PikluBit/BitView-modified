<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////USER MUST BE ADMIN OR MOD
////REQUIRE $_GET["v"]
if (!$_USER->Logged_In)                               { header("location: /"); exit(); }
if (!$_USER->Is_Admin && !$_USER->Is_Moderator)       { header("location: /"); exit(); }
if (!isset($_GET["v"]) || mb_strlen((string) $_GET["v"]) > 11) { header("location: /"); exit(); }


$_VIDEO = new Video($_GET["v"],$DB);

if (!$_VIDEO->exists()) { header("location: /"); exit(); }

$_VIDEO->get_info();


if ($_VIDEO->Info["featured"] == 0) {
    $DB->modify("UPDATE videos SET featured = 1 WHERE url = :URL",
                [":URL" => $_VIDEO->Info["url"]]);
    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Modified video '.$_VIDEO->Info["url"]]);
} else {
    $DB->modify("UPDATE videos SET featured = 0 WHERE url = :URL",
                [":URL" => $_VIDEO->Info["url"]]);
    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Modified video '.$_VIDEO->Info["url"]]);
}
