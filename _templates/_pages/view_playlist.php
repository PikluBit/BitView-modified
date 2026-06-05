<?php
$Video1 = $DB->execute("SELECT url FROM playlists_videos WHERE playlist_id = :ID ORDER BY position ASC LIMIT 1", true, [":ID" => $Playlist["id"]]);
$_OWNER = new User($Playlist["by_user"], $DB);
$_OWNER->get_info();
if (isset($Video1['url']) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/u/thmp/".$Video1['url']."_m.jpg")) {
    $Video1_Thumb = "/u/thmp/".$Video1['url']."_m.jpg";
}
elseif (isset($Video1['url']) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/u/thmp/".$Video1['url'].".jpg")) {
    $Video1_Thumb = "/u/thmp/".$Video1['url'].".jpg";
}
else {
    $Video1_Thumb = "/img/nothump.png";
}
$Total_Length_Videos = $DB->execute("SELECT * FROM playlists_videos INNER JOIN videos ON playlists_videos.url = videos.url WHERE playlist_id = :ID ORDER BY position ASC", false, [":ID" => $Playlist["id"]]);
$Total_Length = 0;
foreach ($Total_Length_Videos as $Vid) {
    $Total_Length += $Vid['length'];
}
if ($Total_Length < 0) {
    $Total_Length_String = "0 " . $LANGS['seconds'];
}
elseif ($Total_Length < 60) {
    $Total_Length_String = $Total_Length . ($Total_Length != 1 ? " " . $LANGS['seconds'] : " " . $LANGS['second']);
}
elseif ($Total_Length >= 60 && $Total_Length < 3570) {
    $Total_Length_String = round($Total_Length / 60) . (round($Total_Length / 60) != 1 ? " " . $LANGS['minutes'] : " " . $LANGS['minute']);
}
else {
    $Total_Length_String = round($Total_Length / 60 / 60) . (round($Total_Length / 60 / 60) != 1 ? " " . $LANGS['hours'] : " " . $LANGS['hour']);
}
?>
<script>
    function _gel(id) {
        return document.getElementById(id);
    }
    function showTooltip(e) {
        document.getElementsByClassName("yt-uix-tooltip-tip-content")[0].innerHTML = e.title;
        var rect = e.getBoundingClientRect();
        var width = e.offsetWidth / 2;
        var height = _gel("masthead-container").offsetHeight + 16 + e.offsetHeight;
        if (_gel('default-language-box')) {
            var eh = _gel('default-language-box').offsetHeight + 30;
        }
        else {
            var eh = 0;
        }
        _gel("yt-uix-tooltip-tip").style.left = (rect.left + width - (window.innerWidth - 970) / 2) - scrollX + "px";
        _gel("yt-uix-tooltip-tip").style.top = rect.top - height - eh + scrollY + "px";
        _gel("yt-uix-tooltip-tip").style.opacity = 1;
    }
    function hideTooltip() {
        _gel("yt-uix-tooltip-tip").style.opacity = 0;
    }
</script>
<div class="ytg-box contained-content">
    <div class="ytg-2col">
        <div id="vpl-thumb-container">
            <span class="vpl-thumbs">
                <span class="vpl-thumb-top">
                    <span class="video-thumb ux-thumb-288">
                        <span class="img">
                            <img alt="<?= $LANGS['plthumbdesc'] ?>" id="vpl-thumb-image" src="<?= $Video1_Thumb ?>">
                        </span>
                    </span>
                </span>
                <span class="vpl-thumb-empty-1">
                    <span class="video-thumb ux-thumb-288"></span>
                </span>
                <span class="vpl-thumb-empty-2">
                    <span class="video-thumb ux-thumb-288"></span>
                </span>
            </span>
        </div>
        <div class="yt-browse-section-header">
            <h1><?= $LANGS['aboutplaylist'] ?></h1>
            <ol>
                <li class="vpl-bold"><?= number_format_lang($Playlist["views"]) ?> <?= $LANGS['videoviews'] ?></li>
                <li><?= str_replace("{n}", $Videos_Amount, $LANGS['uservideoamount']) ?></li>
                <li><?= $LANGS['totallength'] ?>: <?= $Total_Length_String ?></li>
                <li><?= $LANGS['lastupdated'] ?>: <?php
                if (!isset($Playlist['update_date']) || isset($Playlist['update_date']) && $Playlist['update_date'] == "0000-00-00 00:00:00") { echo get_time_ago($Playlist['submit_date']); } else { echo get_time_ago($Playlist['update_date']); } ?></li>
            </ol>
            <?php if (!empty($Playlist['description'])): ?>
            <div id="vpl-description">
                <span class="vpl-bold"><?= $LANGS['desc'] ?>:</span> <?= $Playlist['description'] ?>
            </div>
            <?php endif ?>
        </div>
        <div class="yt-browse-section-header">
            <h1><?= $LANGS['aboutplaylistcreator'] ?></h1>
            <div id="vpl-playlist-owner-profile-img">
                <div class="user-thumb-medium">
                    <div>
                        <a href="/user/<?= $Playlist["by_user"] ?>">
                        <img src="<?= avatar($Playlist["by_user"]) ?>" alt="<?= displayname($Playlist["by_user"]) ?>" title="<?= displayname($Playlist["by_user"]) ?>">
                        </a>
                    </div>
                </div>
            </div>
            <a class="vpl-playlist-owner-big" href="/user/<?= $Playlist["by_user"] ?>"><?= displayname($Playlist["by_user"]) ?></a>
            <ol>
                <li><?= str_replace("{n}", $_OWNER->Info['videos'], $LANGS['uservideoamount']) ?></li>
                <li><?= number_format_lang($_OWNER->Info["video_views"]) ?> <?= $LANGS['videoviews'] ?></li>
                <li><?= number_format_lang($_OWNER->Info["subscribers"]) ?> <?= $LANGS['subscribers'] ?></li>
                <li><?= $LANGS['joined'] ?> <?php setlocale(LC_TIME, $LANGS['languagecode']); echo get_date($_OWNER->Info["registration_date"],$LANGS['longtimeformat']); ?></li>
            </ol>
            <div id="vpl-playlist-owner-bio"></div>
        </div>
    </div>
    <div class="ytg-fl">
        <h1 id="vpl-title">
            <?= $Playlist["title"] ?><span id="vpl-playlist-owner-small"> <?= str_replace("{u}",'<a href="/user/'. $Playlist["by_user"] .'">'. displayname($Playlist["by_user"]) .'</a>',$LANGS['videoby']) ?></span></h1>
        <div id="vpl-action-buttons">
            <button href="/watch?v=<?= $Video1['url'] ?? '' ?>&pl=<?= $_GET['id'] ?>" onclick=";window.location.href=this.getAttribute('href');return false;" title="<?= $LANGS['playalltooltip'] ?>" type="button" id="vpl-play-all-btn" class="yt-uix-button yt-uix-button-primary yt-uix-tooltip" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" role="button">
                <img class="yt-uix-button-icon-play" src="/img/pixel.gif" alt=""> 
                <span class="yt-uix-button-content"><?= $LANGS['playall'] ?></span>
            </button>
        </div>
        <div class="yt-browse-section-header">
            <h1><?= str_replace("{n}",$Videos_Amount,$LANGS['videosinthisplaylist']) ?></h1>
            <ol id="vpl-videos-list">
                <?php foreach ($Videos as $Video): ?>
                <li>
                    <div class="vpl-thumb">
                        <a href="/watch?v=<?= $Video['url'] ?>&pl=<?= $_GET['id'] ?>" class="ux-thumb-wrap contains-addto">
                            <span class="video-thumb ux-thumb-64 ">
                                <span class="clip">
                                    <img src="<?= $Video['thumb'] ?>" alt="Thumbnail" class="" title="<?= $Video['title'] ?>">
                                </span>
                            </span>
                            <span class="video-time"><?= timestamp($Video['length']) ?></span>
                            <span class="video-actions">
                                <button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button>
                            </span>
                            <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span>
                        </a>
                    </div>
                    <div class="vpl-videos-list-info">
                        <span class="vpl-videos-list-info-title">
                            <a title="<?= $Video['title'] ?>" href="/watch?v=<?= $Video['url'] ?>&pl=<?= $_GET['id'] ?>"><?= $Video['title'] ?></a>
                        </span>
                        <span class="vpl-videos-list-info-user"><?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?> </span>
                        <span class="vpl-videos-list-info-views"><?= number_format_lang($Video["views"]) ?> <?= $LANGS['videoviews'] ?></span>
                    </div>
                </li>
                <?php endforeach ?>
            </ol>
        </div>
    </div>
</div>
<div id="yt-uix-tooltip-tip" class="yt-uix-tooltip-tip yt-uix-tooltip-tip-visible" style="left: 0; top: 0;"><div class="yt-uix-tooltip-tip-body"><div class="yt-uix-tooltip-tip-content"></div></div><div class="yt-uix-tooltip-tip-arrow"></div></div>