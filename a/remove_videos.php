<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    die(json_encode(["response" => "login"]));
    header("location: /");
    exit();
}

$Count = 0;
$Videos = $_POST["vid"];
$Videos = explode(",", (string) $Videos);
$Playlist = $_POST["pl"];

$By_User = $DB->execute("SELECT by_user FROM playlists WHERE id = :ID", true, [":ID" => $Playlist])['by_user'];

if ($By_User == $_USER->Username) {
    foreach ($Videos as $Video) {
        $URL = $Video;
        $Position = $DB->execute("SELECT position FROM playlists_videos WHERE url = :URL AND playlist_id = :PLAYLIST", true, [":URL" => $URL, ":PLAYLIST" => $Playlist])["position"];

        $DB->modify(
            "DELETE FROM playlists_videos WHERE url = :URL AND playlist_id = :PLAYLIST",
            [":URL" => $URL, ":PLAYLIST" => $Playlist]
        );
        $DB->modify("UPDATE playlists_videos SET position = position - 1 WHERE position > :POSITION AND playlist_id = :PLAYLIST", [":POSITION" => $Position, ":PLAYLIST" => $Playlist]);
        $DB->modify("UPDATE playlists SET update_date = NOW() WHERE id = :ID",[":ID" => $Playlist]);
    }
    die(json_encode(["response" => "success"]));
}
else {
    die(json_encode(["response" => "error"]));
}