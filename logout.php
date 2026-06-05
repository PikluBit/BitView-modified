<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (isset($_COOKIE['remember'])) {
setcookie("remember", "", ['expires' => time() - 86400 * 30, 'path' => "/"]);
}
$DB->modify("DELETE FROM remember_me WHERE userid = :USERNAME",[":USERNAME" => $_USER->Username]);
$_USER->log_out();
header("location: /");
