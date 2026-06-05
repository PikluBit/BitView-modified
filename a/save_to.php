<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["v"]
if (!$_USER->Logged_In)                               { header("location: /login"); exit(); }
if (!isset($_GET["v"]) || mb_strlen((string) $_GET["v"]) > 11) { header("location: /"); exit();          }

$_VIDEO = new Video($_GET["v"],$DB);

$Playlist = $_GET["pl"];
if ($Playlist != 'favorites') {
    $Playlist_ID = $DB->execute("SELECT id FROM playlists WHERE id = :ID AND by_user = :USERNAME", true, [":ID" => $Playlist, ":USERNAME" => $_USER->Username])["id"];

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
            $DB->modify("UPDATE playlists SET update_date = NOW() WHERE id = :ID",[":ID" => $Playlist_ID]);
        }
    }
}
else {
    $_USER->favorite_video($_VIDEO);
}
?>
<div id="watch-actions-area-container">
    <div id="watch-actions-area" class="yt-rounded"><div class="close-button" onclick="closeDiv(this);"></div>
    <img class="watch-check-grn-circle" src="/img/check-grn-circle-vfl91176.png" style="float: left;margin-right: 8px;">
        <?php if ($Playlist != 'favorites'): ?>
            <div><?= $LANGS['addtoplaylistsuccess'] ?></div>
        <?php else: ?>
            <div><?php if ($_USER->has_favorited($_VIDEO)) : ?><?= $LANGS['favadded'] ?><?php else: ?><?= $LANGS['favremoved'] ?><?php endif ?></div>
        <?php endif ?>
    </div>
</div>