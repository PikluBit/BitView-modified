<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }


function random_string($Characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $Length = null) {
    $charactersLength   = mb_strlen((string) $Characters);
    $randomString       = '';
    for ($i = 0; $i < $Length; $i++) {
        $randomString .= $Characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if (isset($_POST["create_playlist"])) {
    if (isset($_POST["title"]) && !empty($_POST["title"]) && mb_strlen((string) $_POST["title"]) >= 1 && mb_strlen((string) $_POST["title"]) <= 100 && mb_strlen((string) $_POST["description"]) <= 500 && mb_strlen((string) $_POST["tags"]) <= 256) {
        $ID = random_string("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",11);
        $DB->modify("INSERT INTO playlists(id,by_user,title,description,tags,submit_date) VALUES(:ID,:USERNAME,:TITLE,:DESCRIPTION,:TAGS,NOW())",[":ID" => $ID, ":USERNAME" => $_USER->Username, ":TITLE" => $_POST["title"], ":DESCRIPTION" => $_POST["description"], ":TAGS" => $_POST["tags"]]);
        notification(htmlspecialchars((string) $LANGS['plcreated']), "/my_playlist?id=".$ID, "cfeeb2"); 
        exit();
    } else {
        notification(htmlspecialchars((string) $LANGS['pltitleneeded']), "/create_playlist"); 
        exit();
    }
}
$_PAGE = [
    "Page"          => "create_playlist",
    "Page_Type"     => "my_playlists"
];
require "_templates/_structures/main.php";
