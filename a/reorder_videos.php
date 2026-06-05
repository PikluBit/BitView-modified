<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    die(json_encode(["response" => "login"]));
    header("location: /");
    exit();
}

$Video = $_POST["vid"];
$Playlist = $_POST["pl"];
$Position = $_POST["pos"];

$By_User = $DB->execute("SELECT by_user FROM playlists WHERE id = :ID", true, [":ID" => $Playlist])['by_user'];

if ($By_User == $_USER->Username) {
    $Position_O = $DB->execute("SELECT position FROM playlists_videos WHERE url = :URL AND playlist_id = :PLAYLIST", true, [":URL" => $Video, ":PLAYLIST" => $Playlist])["position"];

    if ($DB->Row_Num == 0) { die(json_encode(["response" => "error"])); }

    $Other_video = $DB->execute("SELECT url, position FROM playlists_videos WHERE position = :POSITION AND playlist_id = :PLAYLIST", true, [":POSITION" => $Position,":PLAYLIST" => $Playlist]);

    if ($DB->Row_Num == 0) { die(json_encode(["response" => "error"])); }

    $DB->modify("UPDATE playlists_videos SET position = :OTHER_POSITION WHERE url = :URL AND playlist_id = :PLAYLIST", [":OTHER_POSITION" => $Other_video["position"], ":URL" => $Video, ":PLAYLIST" => $Playlist]);
    $DB->modify("UPDATE playlists_videos SET position = :OLD_POSITION WHERE url = :URL AND playlist_id = :PLAYLIST", [":OLD_POSITION" => $Position_O, ":URL" => $Other_video["url"], ":PLAYLIST" => $Playlist]);

    $DB->modify("UPDATE playlists SET update_date = NOW() WHERE id = :ID",[":ID" => $Playlist]);

    die(json_encode(["response" => "success"]));
}
else {
    die(json_encode(["response" => "error"]));
}