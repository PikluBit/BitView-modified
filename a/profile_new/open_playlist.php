<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["id"])) {
    header("location: /");
    exit();
}

$URL = $_GET['id'];
$_PROFILE = new User($_GET["user"],$DB);
$_PROFILE->get_info();

$Playlist = $DB->execute("SELECT * FROM playlists WHERE id = :ID", true, [":ID" => $_GET["id"]]);

$Videos = new Videos($DB, $_USER);
$Videos->ORDER_BY = "playlists_videos.position ASC";
$Videos->JOIN     = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
$Videos->WHERE_C  = "AND playlists_videos.playlist_id = :PLAYLIST";
$Videos->Execute  = [":PLAYLIST" => $Playlist["id"]];
$Videos->get();

if ($Videos::$Videos) {
    $Videos = $Videos->fix_values(true, true);
} else {
    $Videos = false;
}

$Amount = new Videos($DB, $_USER);
$Amount->JOIN     = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
$Amount->WHERE_C  = "AND playlists_videos.playlist_id = :PLAYLIST";
$Amount->Execute  = [":PLAYLIST" => $Playlist["id"]];
$Amount->get();

$Videos_Amount = $Amount::$Amount;

//ALSO GET ONE LATEST VIDEO
if ($_PROFILE->Info['videos'] >= 1 and empty($_PROFILE->Info['c_featured_video'])) {
    $LatVideo = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 1",false,[":USERNAME" => $_PROFILE->Username],false);
}
elseif ($_PROFILE->Info['videos'] == 0 and $_PROFILE->Info['favorites'] >= 1 and empty($_PROFILE->Info['c_featured_video'])) {
    $LatVideo = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos_favorites.submit_on DESC LIMIT 1",false,[":USERNAME" => $_PROFILE->Username],false);
}
elseif (!empty($_PROFILE->Info['c_featured_video'])) {
    $LatVideoURL = $_PROFILE->Info['c_featured_video'];
    $LatVideo = $DB->execute("SELECT * FROM videos WHERE url = :URL AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 1",false,[":URL" => $LatVideoURL],false);
}

?>
<div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-favorites-holder">
    <div id="playnav-play-favorites-scrollbox" class="scrollbox-wrapper inner-box-colors">
        <div id="playlist-info" style="padding: 6px 6px 0px 6px;">
        <a href="javascript:;" style="border-bottom: 1px dotted;text-decoration: none!important;display: inline-block;margin-bottom: 4px;" onmousedown="selectTab('playlists','<?= $_GET['user'] ?>');">« <?= $LANGS['backtoplaylists'] ?></a>
                                    <h3><?= $Playlist['title'] ?></h3>
                                    <p><?= nl2br((string) $Playlist['description']) ?></p>
                                    <div style="text-align:right;">
                                    <a href="/view_playlist?id=<?= $Playlist["id"] ?>" style="border-bottom: 1px dotted;text-decoration: none!important;display: inline-block;margin-bottom: 4px;"><?= $LANGS['moreinfo'] ?></a>
                                </div>
                            </div>
                                    <div class="scrollbox-separator">
        <div class="outer-box-bg-as-border"></div>
    </div>
            <input type="hidden" id="playnav-playlist-favorites-count" value="90">
        <div class="scrollbox-content playnav-playlist-non-all">
            <div class="scrollbox-body" style="overflow: scroll; zoom: 1;">
                <div class="outer-scrollbox">
                    <div id="playnav-play-favorites-items" class="inner-scrollbox">
                                <div id="playnav-play-favorites-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">

    <?php if ($Videos) : ?>
        <?php $Count = 0 ?>
        <?php foreach ($Videos as $Video) : ?>
            <?php $Count++ ?>
            <div id="playnav-video-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if (isset($LatVideo) && ($LatVideo[0]['url'] ?? '') == $Video['url']): ?>playnav-item-selected<?php endif?>">
            <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

            <div id="playnav-video-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
            <div class="content">
                <div class="playnav-video-thumb link-as-border-color">
                    <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('favorites','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
                </div>
                <div class="playnav-video-info">
                    <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('favorites','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
                    <div class="metadata">
                            <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?>   
                    </div>
                    <div style="display:none" id="playnav-video-play-favorites-<?= $Count ?>"><?= $Video['url'] ?></div>  
                </div>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
                                </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>