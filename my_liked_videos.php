<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }


if (isset($_POST["video"]) && count($_POST["video"]) > 0) {
    $Playlist = $_POST["select_videos"];
    $Playlist_ID = $DB->execute("SELECT id FROM playlists WHERE id = :ID AND by_user = :USERNAME", true, [":ID" => $Playlist, ":USERNAME" => $_USER->Username])["id"];

    if ($DB->Row_Num > 0) {
        $Count = 0;
        foreach ($_POST["video"] as $Video) {
            $_VIDEO = new Video($Video, $DB);

            if ($_VIDEO->exists()) {
                $DB->execute("SELECT url FROM playlists_videos WHERE url = :URL AND playlist_id = :ID", true, [":URL" => $_VIDEO->URL, ":ID" => $Playlist_ID]);

                if ($DB->Row_Num == 0) {
                    $Position = $DB->execute("SELECT position FROM playlists_videos WHERE playlist_id = :ID ORDER BY position DESC LIMIT 1", true, [":ID" => $Playlist_ID]);
                    if ($Position) {
                        $Position = $Position["position"] + 1;
                    } else {
                        $Position = 1;
                    }

                    $DB->modify("INSERT INTO playlists_videos(url,playlist_id,position) VALUES (:URL,:ID,:POSITION)", [":URL" => $_VIDEO->URL, ":ID" => $Playlist_ID, ":POSITION" => $Position]);
                    $Count++;
                }
            }
        }
        notification($LANGS['addvideoplaylist1'].' '.$Count.' '.$LANGS['addvideoplaylist2'],$_SERVER["HTTP_REFERER"],"cfeeb2"); exit();
    }
}


$_USER->get_info();

$_PAGINATION = new Pagination(20,999);
$_PAGINATION->total($_USER->Info["favorites"]);

if (!isset($_GET['sf']) || isset($_GET['sf']) && $_GET['sf'] == "added") {
    $ORDER = "videos_ratings.submit_date DESC";
    $SortBy = $LANGS['sortnewest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "added-old") {
    $ORDER = "videos_ratings.submit_date ASC";
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

$Videos                 = new Videos($DB,$_USER);
$Videos->WHERE_P        = ["videos_ratings.username" => $_USER->Username, "videos.status" => 2];
$Videos->WHERE_C        = " AND videos_ratings.rating >= 3";
$Videos->ORDER_BY       = $ORDER;
$Videos->Private_Videos = true;
$Videos->LIMIT          = $_PAGINATION;
$Videos->JOIN           = "RIGHT JOIN videos_ratings ON videos_ratings.url = videos.url";
$Videos->get();

$Videos_Amount          = $Videos::$Amount;

if ($Videos::$Videos) {
    $Videos = $Videos->fix_values(true,true);
} else {
    $Videos = false;
}

$_PAGE = [
    "Page"          => "my_liked_videos",
    "Page_Type"     => "my_liked_videos",
];
require "_templates/_structures/main.php";
