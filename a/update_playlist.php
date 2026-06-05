<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    die(json_encode(["response" => "login"]));
    header("location: /");
    exit();
}

$Title = $_POST["ti"];
$Description = $_POST["de"];
$Tags = $_POST["ta"];
$URL = $_POST["id"];

$By_User = $DB->execute("SELECT by_user FROM playlists WHERE id = :ID", true, [":ID" => $URL])['by_user'];

if ($By_User == $_USER->Username) {
    if (isset($Title) && !empty($Title) && mb_strlen((string) $Title) >= 1 && mb_strlen((string) $Title) <= 100 && mb_strlen((string) $Description) <= 500 && mb_strlen((string) $Tags) <= 256) {
        $DB->modify("UPDATE playlists SET title = :TITLE, description = :DESCRIPTION, tags = :TAGS WHERE id = :ID", [":TITLE" => $Title, ":DESCRIPTION" => $Description, ":TAGS" => $Tags, ":ID" => $URL]);
        $DB->modify("UPDATE playlists SET update_date = NOW() WHERE id = :ID",[":ID" => $URL]);
        die(json_encode(["response" => "success"]));
    } 
    else {
        die(json_encode(["response" => "error"]));
    }
} else { die(json_encode(["response" => "error"])); }