<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    die(json_encode(["response" => "login"]));
    header("location: /");
    exit();
}

$Videos = $_POST["vid"];
$Videos = explode(",", (string) $Videos);

foreach ($Videos as $Video) {
    $_VIDEO = new Video($Video, $DB);
    if ($_USER->favorite_video($_VIDEO)) { }
    else { die(json_encode(["response" => "error"])); }
}
die(json_encode(["response" => "success"]));