<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
header("Content-Type: application/json", true);

//MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    die(json_encode(["response" => "error"]));
    header("location: /");
    exit();
}

$By_User = $DB->execute("SELECT by_user FROM playlists WHERE id = :ID", true, [":ID" => $_POST["id"]])['by_user'];
if ($By_User == $_USER->Username) {
    $DB->modify("DELETE FROM playlists WHERE id = :ID", [":ID" => $_POST["id"]]);
    die(json_encode(["response" => "success"]));
}
else {
    die(json_encode(["response" => "error"]));
}
die(json_encode(["response" => "success"]));