<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

//PERMISSIONS AND REQUIREMENTS
////"$_GET["v"]" MUST NOT BE LOGGED IN
if (!isset($_GET["v"])) { header("location: /"); exit(); }


$_VIDEO = new Video($_GET["v"],$DB);

if ($_VIDEO->exists()) {
    $_VIDEO->get_info();
    $_VIDEO->check_info();


} else {
    header("location: /"); exit();
}
$_VIDEO->show_video(472,393,false,$LANGS);
?>