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
    "url"         => "required|max_len,12",
    "content"         => "min_len,1"
]);

$_GUMP->filter_rules([
    "url"         => "trim|NoHTML",
    "content"         => "trim"
]);

$Validation     = $_GUMP->run($_POST);
if ($Validation) {
    $URL = $_VIDEO->URL;
    $HTML = htmlspecialchars_decode((string) $Validation['content']);
    if (file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/u/ann/".$URL.".xml", $HTML)) {
        }
    if ($HTML !== "delete") {
        if (file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/u/ann/".$URL.".xml", $HTML)) {
            die(json_encode(["response" => "success"]));
        }
        else {
            die(json_encode(["response" => "error"]));
        }
    }
    elseif ($HTML === "delete") {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/u/ann/".$URL.".xml")) {
            if (@unlink($_SERVER['DOCUMENT_ROOT'] . "/u/ann/".$URL.".xml")) {
                die(json_encode(["response" => "success"]));
            }
            else {
                die(json_encode(["response" => "error"]));
            }
        }
        else {
            die(json_encode(["response" => "success"]));
        }
    }
    else {
        die(json_encode(["response" => "error"]));
    }
}
else {
    die(json_encode(["response" => "error"]));
}