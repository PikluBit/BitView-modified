<?php 
if (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_messages.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "address_book.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "send_message.php" ) {
    $Class = "messages";
}
elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "insight.php") {
    $Class = "insight";
}
elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_subscriptions.php") {
    $Class = "subscriptions";
}
elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_favorites.php") {
    $Class = "favorites";
}
elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_videos.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_videos_annotations.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "edit_video.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_quicklist.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "viewing_history.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_playlists.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_playlist.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "edit_playlist.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "create_playlist.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_liked_videos.php") {
    $Class = "videos";
}
elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_profile.php") {
    $Class = "profile_settings";
}

?>
<?php if (isset($Class)): ?>
<div id="masthead-subnav">
          <ul>
              <li <?php if ($Class == "videos"): ?>class="selected"<?php endif ?>>
                <a href="/my_videos"><?= $LANGS['myvideos&playlists'] ?></a>
              </li>
              <li <?php if ($Class == "favorites"): ?>class="selected"<?php endif ?>>
                <a href="/my_favorites"><?= $LANGS['favorites'] ?></a>
              </li>
              <li>
                <a href="/user/<?= $_USER->Username ?>"><?= $LANGS['mychannel'] ?></a>
              </li>
              <li <?php if ($Class == "subscriptions"): ?>class="selected"<?php endif ?>>
                <a href="/my_subscriptions"><?= $LANGS['subscriptions'] ?></a>
              </li>
              <li <?php if ($Class == "insight"): ?>class="selected"<?php endif ?>>
                <a href="/insight"><?= $LANGS['insight'] ?></a>
              </li>
              <li <?php if ($Class == "messages"): ?>class="selected"<?php endif ?>>
                <a href="/inbox"><?= $LANGS['messagesmenu'] ?></a>
              </li>
              <li class="<?php if ($Class == "profile_settings"): ?>selected <?php endif ?>last">
                <a href="/my_profile"><?= $LANGS['accountsettings'] ?></a>
              </li>
          </ul>
        </div>
<?php endif ?>
<!--
<div class="nav-header">
    <h1><?= $LANGS['myaccount'] ?></h1>
    <ul class="<?= $Class ?? '' ?>">
            <li id="account-videos-link" class="nav-first"><a href="/my_videos"><?= $LANGS['videos'] ?></a></li>
            <li id="account-insight-link"><a href="/insight"><?= $LANGS['insight'] ?></a></li>
            <li id="account-messages-link"><a href="/inbox"><?= $LANGS['messagesmenu'] ?></a></li>
            <li id="account-settings-link"><a href="/my_account"><?= $LANGS['settings'] ?></a></li>
    </ul>
</div>
-->