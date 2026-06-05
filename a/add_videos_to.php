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
$Playlists = $_POST["pl"];
$Playlists = explode(",", (string) $Playlists);
foreach ($Videos as $Video) {
    $_VIDEO = new Video($Video, $DB);

    if ($_VIDEO->exists()) {
        foreach ($Playlists as $Playlist) {
            if ($Playlist == "favorites") {
                $_VIDEO = new Video($Video, $DB);
                if (!$_USER->has_favorited($_VIDEO)) {
                    $Count++;
                    $_USER->favorite_video($_VIDEO);
                }
            }
            else {
                $By_User = $DB->execute("SELECT by_user FROM playlists WHERE id = :ID", true, [":ID" => $Playlist])['by_user'];

                if ($By_User == $_USER->Username) {
                    $DB->execute("SELECT url FROM playlists_videos WHERE url = :URL AND playlist_id = :ID", true, [":URL" => $_VIDEO->URL, ":ID" => $Playlist]);

                    if ($DB->Row_Num == 0) {
                        $Position = $DB->execute("SELECT position FROM playlists_videos WHERE playlist_id = :ID ORDER BY position DESC LIMIT 1", true, [":ID" => $Playlist]);
                        if ($Position) {
                            $Position = $Position["position"] + 1;
                        } else {
                            $Position = 1;
                        }

                        $DB->modify("INSERT INTO playlists_videos(url,playlist_id,position) VALUES (:URL,:ID,:POSITION)", [":URL" => $_VIDEO->URL, ":ID" => $Playlist, ":POSITION" => $Position]);
                        $Count++;
                        $DB->modify("UPDATE playlists SET update_date = NOW() WHERE id = :ID",[":ID" => $Playlist]);
                    }
                } else { die(json_encode(["response" => "error"])); }
            }
        }
    }
}
die(json_encode(["response" => "success"]));