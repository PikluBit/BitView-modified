<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}


if (isset($_POST["video"]) && count($_POST["video"]) > 0) {
    if ($_POST["select_videos"] == 1) {
        $Count = 0;
        foreach ($_POST["video"] as $Video) {
            $_VIDEO = new Video($Video, $DB);
            if (!$_USER->has_favorited($_VIDEO)) {
                $Count++;
                $_USER->favorite_video($_VIDEO);
            }
        }
        notification($LANGS['addfavorite1'].' '.$Count.' '.$LANGS['addfavorite2'], $_SERVER["HTTP_REFERER"], "cfeeb2");
        exit();
    } else {
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
            notification($LANGS['addvideoplaylist1'].' '.$Count.' '.$LANGS['addvideoplaylist2'], $_SERVER["HTTP_REFERER"], "cfeeb2");
            exit();
        }
    }
}

$Types = [
    1 => "Date Added",
    2 => "Views",
    3 => "Title",
    4 => "Time",
    5 => "Rating"
];

if (isset($_GET["t"]) && $_GET["t"] >= 1 && $_GET["t"] <= 7) {
    $Type = (int)$_GET["t"];
} elseif (!isset($_GET["t"])) {
    $Type = 1;
} else {
    header("Location: /my_videos");
}

if (!isset($_GET['sf']) || $_GET['sf'] == "added") {
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

$_USER->get_info();

$_PAGINATION = new Pagination(20, 999);
$_PAGINATION->total($_USER->Info["videos"] + $_USER->Info["private_videos"] + $_USER->Info["converting_videos"]);

$Videos                 = new Videos($DB, $_USER);
$Videos->ORDER_BY       = $ORDER;
$Videos->WHERE_P        = ["videos.uploaded_by" => $_USER->Username];
if (isset($_GET["search"])) {
    $Videos->WHERE_C = "AND title LIKE :SEARCH";
    $Videos->Execute = [":SEARCH" => '%'.$_GET["search"].'%'];
} else {
    $Videos->WHERE_C = "";
}
$Videos->STATUS         = 3;
$Videos->Private_Videos = true;
$Videos->Banned_Users   = true;
$Videos->LIMIT          = $_PAGINATION;
$Videos->get();

$Videos_Amount = $Videos::$Amount;
$Videos = $Videos->fix_values(true, true);

$_PAGE = [
    "Page"          => "my_videos",
    "Page_Type"     => "my_videos"
];
require "_templates/_structures/main.php";