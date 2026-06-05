<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["order"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["username"])) {
    header("location: /");
    exit();
}

$Order = 'videos.uploaded_on';
if ($_GET['order'] == "popularity") {
    $Order = 'videos.views';
} elseif ($_GET['order'] == "rating") {
    $Order = 'videos.5stars';
}

$_PROFILE = new User($_GET["username"],$DB);
$_PROFILE->get_info();

$Videos = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY $Order DESC LIMIT 10",false,[":USERNAME" => $_PROFILE->Username]);

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
                    <div id="playnav-play-uploads-items" style="padding: 0;" class="inner-scrollbox">
                                <div id="playnav-play-uploads-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php if ($Videos): ?>
        <?php $Count = 0; ?>
        <?php foreach ($Videos as $Video) : ?>
            <?php $Count++ ?>
            <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if ($LatVideo[0]['url'] == $Video['url']): ?>playnav-item-selected<?php endif?>">
            <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

            <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
            <div class="content">
                <div class="playnav-video-thumb link-as-border-color">
                    <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('uploads','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
                </div>
                <div class="playnav-video-info">
                    <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('uploads','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
                    <div class="metadata">
                            <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?>   
                    </div>
                    <div style="display:none" id="playnav-video-play-uploads-<?= $Count ?>"><?= $Video['url'] ?></div>  
                </div>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
    <div class="alignC" id="show-more-2"><b><a href="#" onclick="loadVideos('uploads',2, '<?= $_PROFILE->Username ?>','<?= $_GET["order"] ?>');return false;">Show More</a></b></div>
                                </div>         
                    </div>