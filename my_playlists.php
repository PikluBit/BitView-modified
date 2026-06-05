<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}

$Playlists = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC", false, [":USERNAME" => $_USER->Username]);

header("location: /my_playlist?id=".$Playlists[0]['id']);
exit();

$_PAGE = [
    "Page"          => "my_playlists",
    "Page_Type"     => "my_playlists"
];
require "_templates/_structures/main.php";