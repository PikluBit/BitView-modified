<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////MUST BE LOGGED IN
////REQUIRES $_GET["id"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["id"]) && !isset($_POST["id"])) {
    header("location: /");
    exit();
}

if (isset($_POST["id"])) {
    $_GET["id"] = $_POST["id"];
}

$This_Playlist = $DB->execute("SELECT * FROM playlists WHERE id = :ID AND by_user = :USERNAME", true, [":ID" => $_GET["id"], ":USERNAME" => $_USER->Username]);

if (!$This_Playlist) {
    notification($LANGS['plnotexist'], "/");
    exit();
}

$_PAGINATION = new Pagination(20, 999);

if (!isset($_GET['sf']) || isset($_GET['sf']) && $_GET['sf'] == "position") {
    $ORDER = "playlists_videos.position ASC";
    $SortBy = $LANGS['sortorder'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "added") {
    $ORDER = "videos.uploaded_on DESC";
    $SortBy = $LANGS['sortnewest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "added-old") {
    $ORDER = "videos.uploaded_on ASC";
    $SortBy = $LANGS['sortoldest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "viewcount") {
    $ORDER = "videos.views DESC";
    $SortBy = $LANGS['sortmostviewed'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "duration-l") {
    $ORDER = "videos.length DESC";
    $SortBy = $LANGS['sortlongest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "duration-s") {
    $ORDER = "videos.length ASC";
    $SortBy = $LANGS['sortshortest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "title-az") {
    $ORDER = "videos.title ASC";
    $SortBy = $LANGS['sortaz'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "title-za") {
    $ORDER = "videos.title DESC";
    $SortBy = $LANGS['sortza'];
}

$Videos = new Videos($DB, $_USER);
$Videos->SELECT  .= ", playlists_videos.position";
$Videos->ORDER_BY = $ORDER;
$Videos->JOIN     = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
$Videos->WHERE_C  = "AND playlists_videos.playlist_id = :PLAYLIST";
$Videos->Execute  = [":PLAYLIST" => $This_Playlist["id"]];
$Videos->LIMIT    = $_PAGINATION;
$Videos->Private_Videos = true;
$Videos->get();

if ($Videos::$Videos) {
    $Videos = $Videos->fix_values(true, true);
} else {
    $Videos = false;
}

$Amount = new Videos($DB, $_USER);
$Amount->ORDER_BY = $ORDER;
$Amount->JOIN     = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
$Amount->WHERE_C  = "AND playlists_videos.playlist_id = :PLAYLIST";
$Amount->Execute  = [":PLAYLIST" => $This_Playlist["id"]];
$Amount->Private_Videos = true;
$Amount->get();

$_PAGINATION->total($Amount::$Amount);

$_PAGE = [
    "Page"          => "my_playlist",
    "Page_Type"     => "browse"
];
require "_templates/_structures/main.php";
