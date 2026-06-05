<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}
$Playlists = $DB->execute("SELECT playlists.id, playlists.title, count(playlists_videos.url) as amount FROM playlists LEFT JOIN playlists_videos ON playlists.id = playlists_videos.playlist_id WHERE playlists.by_user = :USERNAME GROUP BY playlists.id, playlists_videos.playlist_id ORDER BY playlists.update_date DESC", false, [":USERNAME" => $_USER->Username]);

?>

<?php if ($Playlists) : ?>
    <?php foreach ($Playlists as $Playlist) : ?>
        <li><span class="yt-uix-button-menu-item" onclick="saveTo('<?= $Playlist["id"] ?>');return false;"><?= $Playlist["title"] ?> (<?= str_replace("{n}", $Playlist['amount'], $LANGS['uservideoamount']) ?>)</span></li>
    <?php endforeach ?>
    <li>
        <span class="yt-uix-button-menu-item" onclick="openTextbox(this);return false;"><?= $LANGS['newplaylist'] ?></span>
        <input type="text" class="hid" name="playlist_title" id="playlist-title" style="margin: 4px 6px;">
    </li>
<?php endif ?>