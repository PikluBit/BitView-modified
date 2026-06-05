<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

$_GUMP->validation_rules([
    "fc_title"      => "max_len,60",
    "fc"            => "max_len,125"
]);

$_GUMP->filter_rules([
    "fc_title"      => "trim|NoHTML",
    "fc"            => "trim|NoHTML"
]);

$Validation = $_GUMP->run($_POST);

if ($Validation) {
    $Title      = $Validation["fc_title"];
    $FC         = $Validation["fc"];

    $DB->modify("UPDATE users SET channels_title = :TITLE, channels = :FC WHERE username = :USERNAME",[":TITLE" => $Title, ":FC" => $FC, ":USERNAME" => $_USER->Username]);
    die(json_encode(["response" => "success"]));
}
else {
    die(json_encode(["response" => "error"]));
}
?>