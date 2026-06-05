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

    $annDir = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'u' . DIRECTORY_SEPARATOR . 'ann';
    $annPath = $annDir . DIRECTORY_SEPARATOR . $URL . '.xml';

    // Ensure annotations directory exists
    if (!is_dir($annDir)) {
        if (!@mkdir($annDir, 0777, true) && !is_dir($annDir)) {
            die(json_encode(["response" => "error"]));
        }
    }

    if ($HTML !== "delete") {
        $bytes = @file_put_contents($annPath, $HTML, LOCK_EX);
        if ($bytes === false) {
            die(json_encode(["response" => "error"]));
        }
        die(json_encode(["response" => "success"]));
    }
    elseif ($HTML === "delete") {
        if (file_exists($annPath)) {
            if (@unlink($annPath)) {
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