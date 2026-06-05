<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////REQUIRES $_GET["id"]
if (!isset($_GET["id"]) && !isset($_POST["id"])) {
    header("location: /");
    exit();
}

if (isset($_POST["id"])) {
    $_GET["id"] = $_POST["id"];
}

$This_Playlist = $DB->execute("SELECT * FROM playlists WHERE id = :ID AND by_user = :USERNAME", true, [":ID" => $_GET["id"], ":USERNAME" => $_USER->Username]);

$Playlist = $DB->execute("SELECT * FROM playlists WHERE id = :ID", true, [":ID" => $_GET["id"]]);

if (!$Playlist) {
    notification($LANGS['plnotexist'], "/");
    exit();
}

$Types = [
    1 => "Unsorted",
    2 => "Views",
    3 => "Title",
    4 => "Duration",
    5 => "Comments",
    6 => "Date Added"
];

if (isset($_GET["t"]) && $_GET["t"] >= 1 && $_GET["t"] <= 6) {
    $Type = (int)$_GET["t"];
} elseif (!isset($_GET["t"])) {
    $Type = 1;
} else {
    header("Location: /view_playlist?id=".$_GET['id']);
}

$Videos = new Videos($DB, $_USER);
if ($Type == 1) {
$Videos->ORDER_BY = "playlists_videos.position ASC";
}
if ($Type == 2) {
$Videos->ORDER_BY = "videos.views DESC";
}
if ($Type == 3) {
$Videos->ORDER_BY = "videos.title ASC";
}
if ($Type == 4) {
$Videos->ORDER_BY = "videos.length DESC";
}
if ($Type == 5) {
$Videos->ORDER_BY = "videos.comments DESC";
}
if ($Type == 6) {
$Videos->ORDER_BY = "videos.uploaded_on DESC";
}
$Videos->JOIN     = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
$Videos->WHERE_C  = "AND playlists_videos.playlist_id = :PLAYLIST";
$Videos->Execute  = [":PLAYLIST" => $Playlist["id"]];
$Videos->Private_Videos = true;
$Videos->get();

if ($Videos::$Videos) {
    $Videos = $Videos->fix_values(true, true);
} else {
    $Videos = [];
}

$Amount = new Videos($DB, $_USER);
$Amount->ORDER_BY = "playlists_videos.position ASC";
$Amount->JOIN     = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
$Amount->WHERE_C  = "AND playlists_videos.playlist_id = :PLAYLIST";
$Amount->Execute  = [":PLAYLIST" => $Playlist["id"]];
$Amount->Private_Videos = true;
$Amount->get();

$Videos_Amount = $Amount::$Amount;

$_PAGE = [
    "Page"          => "view_playlist",
    "Page_Type"     => "view_playlist"
];
require "_templates/_structures/main.php";
