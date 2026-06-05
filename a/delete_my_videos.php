<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    die(json_encode(["response" => "login"]));
    header("location: /");
    exit();
}

$Count = 0;
$Videos = $_POST["vid"];
$Videos = explode(",", (string) $Videos);
foreach ($Videos as $Video) {
    $_VIDEO = new Video($Video, $DB);
    if ($_VIDEO->exists()) {
        $_VIDEO->get_info();
        if (($_VIDEO->Info["uploaded_by"] === $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator)) {
            if ($_VIDEO->delete()) {
            } else {
                die(json_encode(["response" => "error"]));
            }
        }
    }
}
die(json_encode(["response" => "success"]));