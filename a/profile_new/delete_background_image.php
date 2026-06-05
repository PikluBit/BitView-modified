<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

$DB->modify("UPDATE users SET c_background_image = '' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
unlink($_SERVER['DOCUMENT_ROOT'].'/u/bck/'.$_USER->Username.'.jpg');

?>