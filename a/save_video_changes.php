<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    die(json_encode(["response" => "login"]));
    header("location: /");
    exit();
}

$_VIDEO = new Video($_POST["url"],$DB);
if (!$_VIDEO->exists()) { die(json_encode(["response" => "error"])); }
$_VIDEO->get_info();
$_VIDEO->check_info();
if ($_VIDEO->Info["uploaded_by"] !== $_USER->Username) { die(json_encode(["response" => "error"])); }

$_GUMP->validation_rules([
    "tit"      => "required|max_len,100",
    "des"      => "max_len,2048",
    "tag"      => "max_len,128",
    "cat"      => "required"
]);

$_GUMP->filter_rules([
    "tit"         => "trim|NoHTML",
    "des"   => "trim|NoHTML",
    "tag"          => "trim|NoHTML"
]);

$Validation     = $_GUMP->run($_POST);
if ($Validation) {
    $_VIDEO->change_info([
        "title"       => $Validation["tit"],
        "description" => $Validation["des"],
        "tags"        => $Validation["tag"],
        "privacy"     => $Validation["pri"],
        "e_comments"  => $Validation["com"],
        "e_ratings"   => $Validation["rat"],
        "category"    => $Validation["cat"]
    ]);
    die(json_encode(["response" => "success"]));
}
else {
    die(json_encode(["response" => "error"]));
}